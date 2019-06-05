<?php

namespace Controller;

use Core\Template;

class Home extends AbstractController
{
  const BOOKS_DIR = 'books';

  public function __construct()
  {
    parent::__construct(new Template());
  }

  public function indexMethod()
  {
    return parent::getView(
      __METHOD__,
      [
        'title' => APP_NAME.' - Home',
        'header' => 'Welcome to '.APP_NAME,
        'books' => $this->dirToArray(getenv('STORAGE_ROOT') . self::BOOKS_DIR)
      ]
    );
  }

  private function dirToArray (string $dir) : array
  {
    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
      if (!in_array($value,array(".",".."))) {
        if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
          $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
        }
        else {
          $result[] = $value;
        }
      }
    }
    return $result;
  }

}
