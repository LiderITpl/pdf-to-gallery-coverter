<?php
  namespace PdfToGallery;
  
  use Spatie\PdfToImage\Exceptions\InvalidFormat;
  use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
  use Spatie\PdfToImage\Pdf;

  class PdfConvert {
  
    /**
     * @param string $pathToPdf
     * @param string $outputDir
     * @param string $ext // jpg, jpeg, png
     * @throws PdfDoesNotExist
     * @throws InvalidFormat
     */
    public static function toImage(string $pathToPdf, string $outputDir, string $ext = 'jpeg') {
      $pdf = new Pdf($pathToPdf);
      $pdf->setOutputFormat($ext);
      $pdf->saveImage($outputDir);
    }
    
  }