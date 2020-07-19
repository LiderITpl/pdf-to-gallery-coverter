<?php
  namespace PdfToGallery;
  
  use Exception;
  use setasign\Fpdi\Fpdi;

  class PdfSplit {
  
    /**
     * @param string $filePath
     * @param string $outputPath
     * @return array
     * @throws Exception
     */
    public static function splitPages(string $filePath, string $outputPath) {
      $resultingPages = [];
  
      $pdf = new FPDI();
      $pagesCount = $pdf->setSourceFile($filePath); // How many pages?
  
      $fpId = $pdf->importPage(1);
      $fpDimensions = $pdf->getImportedPageSize($fpId);
  
      // Split each page into a new PDF
      for ($i = 1; $i <= $pagesCount; $i++) {
        $newPdf = new FPDI(
            $fpDimensions['orientation'], 'mm',
            [ $fpDimensions['width'], $fpDimensions['height'] ]
        );
        
        $newPdf->setSourceFile($filePath);
        $importedPageId = $newPdf->importPage($i);
        
        $newPdf->AddPage();
        $newPdf->useTemplate($importedPageId);
  
        $newFilename = $outputPath . DIRECTORY_SEPARATOR . 'page-' . $i . '.pdf';
        $newPdf->Output($newFilename, "F");
        array_push($resultingPages, $newFilename);
      }
  
      $pdf->close();
      
      return $resultingPages;
    }
    
  }