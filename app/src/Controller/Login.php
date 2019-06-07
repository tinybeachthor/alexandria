<?php

namespace Controller;

use Core\Template;
use Core\Request;

class Login extends AbstractController
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
        'title' => APP_NAME.' - Login',
        'header' => 'Welcome to '.APP_NAME,
      ]
    );
  }

}
