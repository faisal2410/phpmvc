<?php

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $path, array $params = []): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }

    public function match(string $path): array|bool
    {
        foreach ($this->routes as $route) {
        
            $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";

            echo $pattern, "\n", $route["path"], "\n";

            $this->getPatternFromRoutePath($route["path"]);

            if (preg_match($pattern, $path, $matches)) {

                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

                return $matches;
            }
        }

        return false;
    }

    private function getPatternFromRoutePath(string $route_path)
    {
        $route_path = trim($route_path, "/");

        $segments = explode("/", $route_path);

        $segments = array_map(function(string $segment): string {

            preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches);

            $segment = "(?<" . $matches[1] . ">[a-z]+)";

            return $segment;

        }, $segments);

        $pattern = "#^" . implode("/", $segments) . "$#";

        echo $pattern, "\n";
    }
}