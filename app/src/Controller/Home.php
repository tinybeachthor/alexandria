<?php

namespace Controller;

use Core\Template;

class Home extends AbstractController
{
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
        'header' => 'Welcome to '.APP_NAME
      ]
    );

  }
}
