<?php

namespace Controller;

use Core\Template;
use Core\Request;

use Controller\Book;

class Home extends AbstractController
{
  public function __construct()
  {
    parent::__construct();
  }

  public function indexMethod(Request $request)
  {
    return parent::getView(
      __METHOD__,
      [
        'title' => APP_NAME.' - Home',
        'header' => 'Welcome to '.APP_NAME,
        'books' => $this->dirToArray(getenv('STORAGE_ROOT') . Book::BOOKS_DIR),
        'devices' => $this->dirToArray(getenv('STORAGE_ROOT') . Device::DEVICES_DIR),
      ]
    );
  }

  private function dirToArray (string $dir) : array
  {
    $result = array();

    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
      if (!in_array($value,array(".",".."))) {
        $result[] = $value;
      }
    }
    return $result;
  }

}
