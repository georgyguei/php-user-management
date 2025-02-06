<?php

define("ROOT_DIR", __DIR__);

require_once ROOT_DIR . "/routers/Router.php";

$router = new Router();
$router->routeReq();