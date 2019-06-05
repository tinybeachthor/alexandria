<?php

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use Exception;

class Template
{
  const RESERVED_VARIABLES = ['application_name', 'body'];

  private $viewPath;
  private $twig;

  public function __construct()
  {
    $this->viewPath = getenv('APP_ROOT') . 'templates';

    $loader = new FilesystemLoader($this->viewPath);
    $this->twig = new Environment($loader);
  }

  public function getView($controller, array $variables = [])
  {
    $variables = $this->validateVariables($variables);

    $parts = explode('::', $controller);
    $directory = $this->getDirectory($parts[0]);
    $file = $this->getFile($parts[1]);

    $path = $directory.'/'.$file.'.html.twig';
    try {
      return ($this->twig)->render($path, $variables);
    }
    catch (Exception $e) {
      http_response_code(404);
      throw new Exception(sprintf('View cannot be found: [%s]', $path), 404);
    }
  }

  private function validateVariables(array $variables = [])
  {
    foreach ($variables as $name => $value) {
      if (in_array($name, self::RESERVED_VARIABLES)) {
        http_response_code(404);
        throw new Exception("Unacceptable view variable given: $name", 409);
      }
    }

    $variables['application_name'] = APP_NAME;

    return $variables;
  }

  private function getDirectory($controller)
  {
    $parts = explode('\\', $controller);

    return end($parts);
  }

  private function getFile($controller)
  {
    return str_replace(APP_CONTROLLER_METHOD_SUFFIX, null, $controller);
  }
}

