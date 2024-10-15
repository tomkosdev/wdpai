<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/MapsController.php';
require_once 'src/controllers/SecurityController.php';

class Router {

  public static $routes;

  public static function get($url, $view) {
    self::$routes[$url] = $view;
  }

  public static function post($url, $view) {
    self::$routes[$url] = $view;
  }

  public static function run ($url) {
    // $action = explode("/", $url)[0];


    $action = $url;

    if (!array_key_exists($action, self::$routes)) {
      $action = 'error404';
    }

    $controller = self::$routes[$action];
    $object = new $controller;
    $action = $action ?: 'index';

    $object->$action();
  }
}