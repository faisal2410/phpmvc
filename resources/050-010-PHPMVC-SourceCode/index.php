<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

require "src/router.php";

$router = new Router;

$segments = explode("/", $path);

$action = $segments[2];
$controller = $segments[1];

require "src/controllers/$controller.php";

$controller_object = new $controller;

$controller_object->$action();