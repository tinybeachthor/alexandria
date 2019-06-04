<?php

require_once getenv('APP_ROOT') . 'config.php';
require_once getenv('APP_ROOT') . 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\SyslogHandler;

use Core\Request;

$log = new Logger('default');
$log->pushHandler(new SyslogHandler());
$log->warning('Foo');

$request = new Request($_SERVER, $_POST, $_GET, $_FILES);

try {
  $controller = $request->getController();
  $method = $request->getMethod($controller);

  $controller = new $controller;
  echo $controller->$method();
}
catch (Exception $e) {
  echo sprintf(
    '<h3>%s</h3><h4>%s</h4><h5>%s:%s</h5>',
    $e->getCode(),
    $e->getMessage(),
    $e->getFile(),
    $e->getLine()
  );
}

