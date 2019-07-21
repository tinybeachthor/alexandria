<?php

namespace Controller;

use Core\Request;

class Device extends AbstractController
{
  const DEVICES_DIR = 'devices';

  private $target_dir;

  public function __construct()
  {
    parent::__construct();

    $this->target_dir = getenv('STORAGE_ROOT') . self::DEVICES_DIR;
    if(!is_dir($this->target_dir)) {
      mkdir($this->target_dir, 0777, true);
    }
  }

  public function indexMethod()
  {
    return parent::getView(
      __METHOD__,
      [
        'title' => APP_NAME.' - Create Device',
      ]
    );
  }

  public function createMethod(Request $request)
  {
    $post = $request->getPost();

    $name = $post['name'];

    if ($name == '') {
      http_response_code(400);
      exit();
    }

    $dir = $this->target_dir."/".$name;

    // create directory for device
    mkdir($dir, 0777, true);
    mkdir($dir.'/books', 0777, true);

    // redirect to home
    header('Location: /', true, 302);
    exit();
  }
}
