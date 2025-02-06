<?php

class ControllerHome
{
  private $_userManager;
  private $_view;

  public function __construct($url)
  {
    if (isset($url) && is_array($url) && count($url) > 1) {
      throw new Exception("Page not found", 404);
    } else {
      require_once __DIR__ . "/../views/index.html";
    }
  }
}