<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router)
    {
    }

    public function handle(string $path)
    {
        $params = $this->router->match($path);

        if ($params === false) {

            exit("No route matched");

        }

        $action = $params["action"];
        $controller = "App\Controllers\\" . ucwords($params["controller"]);

        $controller_object = new $controller;

        $this->getActionArguments($controller, $action);

        $controller_object->$action();
    }

    private function getActionArguments(string $controller, string $action)
    {
        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {

            $name = $parameter->getName();

            echo $name, " ";

        }
    }
}