<?php

namespace Controller;

use Monolog\Logger;
use Monolog\Handler\SyslogHandler;

use Core\Request;

class Login extends AbstractController
{
  private $log;

  public function __construct()
  {
    parent::__construct();

    $this->log = new Logger('login');
    ($this->log)->pushHandler(new SyslogHandler(APP_NAME));
  }

  public function indexMethod()
  {
    return parent::getView(
      __METHOD__,
      [
        'title' => APP_NAME.' - Login',
        'header' => 'Welcome to '.APP_NAME,
      ]
    );
  }

  public function loginMethod(Request $request)
  {
    $post = $request->getPost();
    $session = $request->getSession();

    $uname = $post['uname'];
    $upswd = $post['psw'];

    if ($session->login($uname, $upswd)) {
      ($this->log)->info("'$uname' logged in.");

      // redirect to home page
      header('Location: /');
      exit();
    }
    else {
      ($this->log)->warning('Wrong login.');

      // redirect to login page
      header('Location: /login', true, 302);
      exit();
    }
  }

  public function logoutMethod(Request $request)
  {
    $session = $request->getSession();
    $session->logout();

    header('Location: /login', true, 302);
    exit();
  }

}
