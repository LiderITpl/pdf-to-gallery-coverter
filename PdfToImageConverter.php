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
        $resultingPages = PdfSplit::splitPages($filePath, __DIR__ . '/output');
        foreach($resultingPages as $pagePath) {
          $newFileName = __DIR__ . '/output' . '/' . self::getFileNameFromPath($filePath) . '.png';
          PdfConvert::toImage($pagePath, $newFileName, 'png');
          array_push($images, $newFileName);
        }
      } catch(Exception $e) {
        throw new ConvertPdfFileException($e);
      }
      
      return $images;
    }
    
    private static function getFileNameFromPath(string $filePath) {
      $filePathLevels = explode(DIRECTORY_SEPARATOR, $filePath);
      $fileName = $filePathLevels[sizeof($filePathLevels) - 1];
      return str_replace('.pdf', '', $fileName);
    }
  
  }