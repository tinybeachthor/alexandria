<?php

require_once getenv('APP_ROOT') . 'config.php';
require_once getenv('APP_ROOT') . 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\SyslogHandler;

use Core\Request;

session_start([
  'cookie_lifetime' => 60 * 60 * 24 * 7, // 7days
]);

$request = new Request(
  $_SERVER, $_POST, $_GET, $_FILES, $_SESSION
);

$log = new Logger('index');
$log->pushHandler(new SyslogHandler(APP_NAME));

const PUBLIC_CONTROLLERS = [
  APP_CONTROLLER_NAMESPACE.'Login',
];

try {
  $controller = $request->getController();
  $method = $request->getMethod($controller);
  $session = $request->getSession();

  // check if logged in or accessing a public controller
  if (
    $session->isLoggedIn() ||
    in_array($controller, PUBLIC_CONTROLLERS)
  ) {
    $controller = new $controller;
    echo $controller->$method($request);
  }
  else {
    // redirect to login page
    header('Location: /login', true, 302);
    exit();
  }
}
catch (Exception $e) {
  $message = sprintf(
    '<h3>%s</h3><h4>%s</h4><h5>%s:%s</h5>',
    $e->getCode(),
    $e->getMessage(),
    $e->getFile(),
    $e->getLine()
  );
  $log->error($message);
  echo $message;
}
