<?php

namespace Core;

class Session
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

  public function login
  (
    string $uname,
    string $upswd
  ) : bool
  {
    if (
      $uname === getenv('ADMIN_USERNAME') &&
      $upswd === getenv('ADMIN_PASSWORD')
    ) {
      $this->set(self::USERNAME_KEY, $uname);
      return true;
    }

    return false;
  }

  private function set
  (
    string $key,
    string $value
  )
  {
    $_SESSION[$key] = $value;
    $this->session[$key] = $value;
  }
}
