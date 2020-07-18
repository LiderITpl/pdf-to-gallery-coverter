<?php
  namespace PdfToGallery;
  
  use Exception;
  use setasign\Fpdi\Fpdi;

  class PdfSplit {
  
    /**
     * @param string $filePath
     * @param bool $endDirectory
     * @return array
     * @throws Exception
     */
    public static function splitPages(string $filePath, $endDirectory = false) {
      $endDirectory = $endDirectory ? $endDirectory : './';
      $filePathLevels = explode(DIRECTORY_SEPARATOR, $filePath);
      $fileName = $filePathLevels[sizeof($filePathLevels) - 1];
      $noExtensionFileName = str_replace('.pdf', '', $fileName);
      $outputPath = $endDirectory . '/' . $noExtensionFileName;
      $resultingPages = [];
  
      if (!is_dir($outputPath))
        mkdir($outputPath, 0777, true);
  
      $pdf = new FPDI();
      $pagecount = $pdf->setSourceFile($filePath); // How many pages?
  
      // Split each page into a new PDF
      for ($i = 1; $i <= $pagecount; $i++) {
        $new_pdf = new FPDI();
        $new_pdf->AddPage();
        $new_pdf->setSourceFile($filePath);
        $new_pdf->useTemplate($new_pdf->importPage($i));
  
        $newFilename = $outputPath . '/' . 'page-' . $i . '.pdf';
        $new_pdf->Output($newFilename, "F");
        array_push($resultingPages, $newFilename);
      }
  
      $pdf->close();
      
      return $resultingPages;
    }
    
  }