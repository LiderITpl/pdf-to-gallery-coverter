<?php
  namespace PdfToGallery;
  
  use Exception;
  use PdfToGallery\Bootstrap\MySQL\MySqlDbConnException;
  use PdfToGallery\Bootstrap\MySQL\MySqlSingleton;
  use PdfToGallery\Exceptions\ConvertPdfFileException;
  use PdfToGallery\Exceptions\InvalidPdfFileException;

  class PdfToImageConverter {
  
    /**
     * PdfToImageConverter constructor.
     * @param array $mysqlCredentials
     * @throws MySqlDbConnException
     */
    public function __construct(array $mysqlCredentials) {
      MySqlSingleton::open([
          $mysqlCredentials['MYSQL_HOST'],
          $mysqlCredentials['MYSQL_USER'],
          $mysqlCredentials['MYSQL_PASSWORD'],
          $mysqlCredentials['MYSQL_DB_NAME']
      ]);
    }
  
    /**
     * @param array $file
     * @param string $endDirectory
     * @param string $imgExtension
     * @throws ConvertPdfFileException
     * @throws InvalidPdfFileException
     */
    public function splitAndConvert(array $file, string $endDirectory, string $imgExtension = 'png') {
      if(!isset($file))
        throw new InvalidPdfFileException('Nie podano pliku');
  
      $filePath = $file['tmp_name'];
      
      if(!file_exists($filePath))
        throw new InvalidPdfFileException("Plik o podanej ścieżce `{$filePath}` nie istnieje.");
      
      if(mime_content_type($filePath) !== 'application/pdf')
        throw new InvalidPdfFileException("Plik nie jest typu PDF");
      
      try {
        $outputPath = self::generateOutputPath($endDirectory);
  
        // INSERT FILE TO DB
        $pdfFileId = DatabasePopulator::insertFile($file, $outputPath);
        
        // SPLIT PDF
        $resultingPages = PdfSplit::splitPages($filePath, $outputPath);
        
        // CONVERT TO IMG & INSERT IMG TO DB
        for($i=1; $i<=sizeof($resultingPages); $i++) {
          $pdfPath = $resultingPages[$i - 1];
          $newImagePath = $outputPath . DIRECTORY_SEPARATOR . 'page-' . $i . '.' . $imgExtension;
          PdfConvert::toImage($pdfPath, $newImagePath, $imgExtension);
          DatabasePopulator::insertImage($pdfFileId, $newImagePath);
          unlink($pdfPath); // remove old pdf file
        }
      } catch(Exception $e) {
        throw new ConvertPdfFileException($e);
      }
    }
  
    private function generateOutputPath($endDirectory = false) {
      $endDirectory = $endDirectory ? $endDirectory : '.' . DIRECTORY_SEPARATOR;
      $outputPath = null;
    
      do {
        $outputPath = $endDirectory . DIRECTORY_SEPARATOR . uniqid();
      } while(is_dir($outputPath));
    
      mkdir($outputPath, 0777, true);
    
      return $outputPath;
    }
    
    public function __destruct() {
      MySqlSingleton::close();
    }
  
  }