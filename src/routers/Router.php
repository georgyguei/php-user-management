<?php

require_once ROOT_DIR . "/views/View.php";
require_once ROOT_DIR . "/controllers/ControllerHome.php";

class Router
{
  private $_ctrl;
  private $view;

  public function routeReq()
  {
    try {
      spl_autoload_register(function ($class) {
        require_once ROOT_DIR . "/models/{$class}.php";
      });

      $url = "";

      if (isset($_GET["url"])) {
        $url = explode("/", filter_var($_GET["url"], FILTER_SANITIZE_URL));

        $controller = ucfirst(strtolower($url[0]));
        $controllerClass = "Controller{$controller}";
        $controllerFile = ROOT_DIR . "/controllers/{$controllerClass}.php";

        if (file_exists($controllerFile)) {
          require_once $controllerFile;
          $this->_ctrl = new $controllerClass($url);
        } else {
          throw new Exception("Page not found");
        }
      } else {
        require_once ROOT_DIR . "/controllers/ControllerHome.php";
        $this->_ctrl = new ControllerHome($url);
      }
    } catch (Exception $e) {
      $this->view = new View();
      $this->view->generate([
        "success" => false,
        "status" => $e->getCode(),
        "message" => $e->getMessage()
      ]);
    }
  }
}