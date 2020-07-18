<?php
  namespace PdfToGallery\Exceptions;
  
  use Exception;

  class InvalidPdfFileException extends Exception {
  
    public function __construct(string $message, Exception $previous = null) {
      parent::__construct( "Nieprawidłowy plik źródłowy: " . $message, 0, $previous );
    }
  
  }