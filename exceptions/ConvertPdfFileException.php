<?php
  namespace PdfToGallery\Exceptions;
  
  use Exception;

  class ConvertPdfFileException extends Exception {
  
    public function __construct(Exception $previous = null) {
      parent::__construct( "Błąd konwertowania pliku PDF.", 0, $previous );
    }
  
  }