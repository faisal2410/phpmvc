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

            if (preg_match($pattern, $path, $matches)) {

                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

                return $matches;
            }
        }

        return false;
    }
}