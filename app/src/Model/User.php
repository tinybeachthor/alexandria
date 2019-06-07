<?php

namespace Model;

class User
{
  const USERNAME_KEY = 'USERNAME';

  private $session;

  public function __construct
  (
    array $session = []
  )
  {
    $this->session = $session;
  }

  public function isLoggedIn() : bool
  {
    if (isset($this->session[self::USERNAME_KEY])) {
      return true;
    }
    else {
      return false;
    }
  }
}
