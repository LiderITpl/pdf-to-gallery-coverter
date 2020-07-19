<?php
  namespace PdfToGallery\Models;
  
  use PdfToGallery\Bootstrap\MySQL\MySqlQueryException;
  use PdfToGallery\Exceptions\ModelValidationException;
  use function PdfToGallery\Bootstrap\MySQL\getMysql;
  use function PdfToGallery\Bootstrap\Utils\dump;

  class ImgFile extends ModelBase {
    
    public function __construct(array $attributes = []) {
      parent::__construct(
          ['id', 'pdf_file_id', 'img_path'],
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
        INSERT INTO img_files (pdf_file_id, img_path)
        VALUES ({$attrs['pdf_file_id']}, '{$attrs['img_path']}')
EOD;
      $this->id = getMysql()->insert($sql);
    }
  
    protected function update() {
      // Niepotrzebne na razie
    }
  }