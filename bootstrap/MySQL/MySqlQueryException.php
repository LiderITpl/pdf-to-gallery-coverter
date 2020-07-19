<?php
  namespace PdfToGallery\Bootstrap\MySQL;
  
  use Exception;

  class MySqlQueryException extends Exception {
  
    public function __construct($message="", Exception $previous = null) {
    
      parent::__construct(
        "Odpytywanie bazy danych nie powiodło się: ".$message,
        0, $previous
      );
    }
    
  }