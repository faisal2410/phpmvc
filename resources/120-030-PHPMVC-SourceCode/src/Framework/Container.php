<?php

namespace Framework;

use ReflectionClass;

class Container
{
    private array $registry = [];

    public function set(string $name, $value): void
    {
        $this->registry[$name] = $value;
    }

    public function get(string $class_name): object
    {
        if (array_key_exists($class_name, $this->registry)) {

            return $this->registry[$class_name];

        }

        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor === null) {

            return new $class_name;

        }

        foreach ($constructor->getParameters() as $parameter) {

            $type = (string) $parameter->getType();

            $dependencies[] = $this->get($type);

        }

        return new $class_name(...$dependencies);
    }
}