<?php
  namespace PdfToGallery;
  
  use PdfToGallery\Bootstrap\MySQL\MySqlQueryException;
  use PdfToGallery\Exceptions\ModelValidationException;
  use PdfToGallery\Models\ImgFile;
  use PdfToGallery\Models\PdfFile;

  class DatabasePopulator {
  
    /**
     * @param array $file
     * @param string $outputPath
     * @return int
     * @throws ModelValidationException
     * @throws MySqlQueryException
     */
    public static function insertFile(array $file, string $outputPath) {
      $pdfFile = new PdfFile($file);
      $pdfFile->output = $outputPath;
      $pdfFile->save();
      return $pdfFile->id;
    }
  
    /**
     * @param int $pdfFileId
     * @param string $imagePath
     * @return int
     * @throws ModelValidationException
     * @throws MySqlQueryException
     */
    public static function insertImage(int $pdfFileId, string $imagePath) {
      $imgFile = new ImgFile([
        'pdf_file_id' => $pdfFileId,
        'img_path' => $imagePath,
      ]);
      $imgFile->save();
      return $imgFile->id;
    }
    
  }