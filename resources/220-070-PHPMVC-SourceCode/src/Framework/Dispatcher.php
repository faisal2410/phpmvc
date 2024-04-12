<?php

declare(strict_types=1);

namespace Framework;

use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;
use UnexpectedValueException;

class Dispatcher
{
    public function __construct(private Router $router,
                                private Container $container)
    {
    }

    public function handle(Request $request)
    {
        $path = $this->getPath($request->uri);

        $params = $this->router->match($path, $request->method);

        if ($params === false) {

            throw new PageNotFoundException("No route matched for '$path' with method '{$request->method}'");

        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controller_object = $this->container->get($controller);

        $controller_object->setRequest($request);

        $controller_object->setViewer($this->container->get(TemplateViewerInterface::class));

        $args = $this->getActionArguments($controller, $action, $params);

        $controller_object->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];
        
        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {

            $name = $parameter->getName();

            $args[$name] = $params[$name];

        }

        return $args;
    }

    private function getControllerName(array $params): string
    {
        $controller = $params["controller"];

        $controller = str_replace("-", "", ucwords(strtolower($controller), "-"));

        $namespace = "App\Controllers";

        if (array_key_exists("namespace", $params)) {

            $namespace .= "\\" . $params["namespace"];

        }

        return $namespace . "\\" . $controller;
    }

    private function getActionName(array $params): string
    {
        $action = $params["action"];

        $action = lcfirst(str_replace("-", "", ucwords(strtolower($action), "-")));

        return $action;
    }

    private function getPath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if ($path === false) {
        
            throw new UnexpectedValueException("Malformed URL: '$uri'");
        
        }        

        return $path;
    }
}