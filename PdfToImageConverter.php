<?php
  namespace PdfToGallery;
  
  use Exception;
  use PdfToGallery\Exceptions\ConvertPdfFileException;
  use PdfToGallery\Exceptions\InvalidPdfFileException;

  class PdfToImageConverter {
  
    /**
     * @param string $filePath
     * @return array
     * @throws ConvertPdfFileException
     * @throws InvalidPdfFileException
     */
    public static function convertPdf(string $filePath) {
      if(!isset($filePath))
        throw new InvalidPdfFileException('Nie podano ścieżki do pliku');
      
      if(!file_exists($filePath))
        throw new InvalidPdfFileException("Plik o podanej ścieżce `{$filePath}` nie istnieje.");
      
      if(mime_content_type($filePath) !== 'application/pdf')
        throw new InvalidPdfFileException("Plik nie jest typu PDF");
      
      $images = [];
      
      try {
        $endDirectory = __DIR__ . DIRECTORY_SEPARATOR  . 'output';
        $outputPath = self::generateOutputPath($endDirectory);
        
        $resultingPages = PdfSplit::splitPages($filePath, $outputPath);
        
        for($i=1; $i<=sizeof($resultingPages); $i++) {
          $pdfPath = $resultingPages[$i - 1];
          $newImagePath = $outputPath . DIRECTORY_SEPARATOR . 'page-' . $i . '.png';
          
          PdfConvert::toImage($pdfPath, $newImagePath, 'png');
  
          //unlink($pdfPath);
          
          array_push($images, $newImagePath);
        }
      } catch(Exception $e) {
        throw new ConvertPdfFileException($e);
      }
      
      return $images;
    }
  
    private static function generateOutputPath($endDirectory = false) {
      $endDirectory = $endDirectory ? $endDirectory : '.' . DIRECTORY_SEPARATOR;
      $outputPath = null;
    
      do {
        $outputPath = $endDirectory . DIRECTORY_SEPARATOR . uniqid();
      } while(is_dir($outputPath));
    
      mkdir($outputPath, 0777, true);
    
      return $outputPath;
    }
  
  }