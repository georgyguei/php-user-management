<?php

class View
{
  public function generate($data)
  {
    http_response_code($data["status"]);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  }
}