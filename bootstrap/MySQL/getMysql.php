<?php
  namespace PdfToGallery\Bootstrap\MySQL;

  function getMysql() {
    return MySqlSingleton::getInstance();
  }