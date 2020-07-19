<?php
  namespace PdfToGallery\Models;
  
  use PdfToGallery\Bootstrap\MySQL\MySqlQueryException;
  use PdfToGallery\Exceptions\ModelValidationException;
  use function PdfToGallery\Bootstrap\MySQL\getMysql;

  class PdfFile extends ModelBase {
    protected $excludedValidationFields = ['id', 'insert_time'];
    
    public function __construct(array $attributes = []) {
      parent::__construct(
          ['id', 'output', 'name', 'size', 'insert_time'],
          $attributes
      );
    }
  
    /**
     * @throws ModelValidationException
     * @throws MySqlQueryException
     */
    protected function insert() {
      $attrs = $this->validateAttrs();
      $sql = <<<EOD
        INSERT INTO pdf_files (name, output, size, insert_time)
        VALUES ('{$attrs['name']}', '{$attrs['output']}', '{$attrs['size']}', FROM_UNIXTIME({$attrs['insert_time']}))
EOD;
      $this->id = getMysql()->insert($sql);
    }
  
    protected function update() {
      // Na razie nie jest potrzebne
    }
    
    protected function validateAttrs() {
      if(!isset($this->insert_time)) {
        $this->insert_time = time();
      }
      return parent::validateAttrs();
    }
  
  }