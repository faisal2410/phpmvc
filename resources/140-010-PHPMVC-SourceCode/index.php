<?php

declare(strict_types=1);

spl_autoload_register(function (string $class_name) {

    require "src/" . str_replace("\\", "/", $class_name) . ".php";

});

set_error_handler("Framework\ErrorHandler::handleError");

set_exception_handler(function (Throwable $exception) {

    if ($exception instanceof Framework\Exceptions\PageNotFoundException) {

        http_response_code(404);

        $template = "404.php";

    } else {
    
        http_response_code(500);

        $template = "500.php";

    }

    $show_errors = true;

    if ($show_errors) {

        ini_set("display_errors", "1");

    } else {

        ini_set("display_errors", "0");

        ini_set("log_errors", "1");

        require "views/$template";

    }

    throw $exception;

});

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($path === false) {

    throw new UnexpectedValueException("Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'");

}

$router = new Framework\Router;

$router->add("/admin/{controller}/{action}", ["namespace" => "Admin"]);
$router->add("/{title}/{id:\d+}/{page:\d+}", ["controller" => "products", "action" => "showPage"]);
$router->add("/product/{slug:[\w-]+}", ["controller" => "products", "action" => "show"]);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);
$router->add("/{controller}/{action}");

$container = new Framework\Container;

$container->set(App\Database::class, function() {

    return new App\Database("localhost", "product_db", "product_db_user", "secret");

});

$dispatcher = new Framework\Dispatcher($router, $container);

$dispatcher->handle($path);
