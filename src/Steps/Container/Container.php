<?php

namespace Run\Steps\Container;

use Psr\Container\ContainerInterface;
use Run\Exceptions\Container\ContainerException;

class Container implements ContainerInterface
{
    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    private array $entries = [];

    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string|callable  $abstract
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \Run\Exceptions\Container\BindingResolutionException
     */
    public function make($abstract, array $parameters = [])
    {
        return $this->resolve($abstract, $parameters);
    }

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    protected function resolve(string $id ,$parameters = [])
    {
        //  1. Inspect the class that we are trying to get from the container
        $reflectionClass = new \ReflectionClass($id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException('Class "' . $id . '" is not instantiable');
        }

        // 2. Inspect the constructor of the class
        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        // 3. Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        // 4. If the constructor parameter is a class then try to resolve that class using the container
        $dependencies = array_map(function (\ReflectionParameter $param) use ($id) {
                $type = $param->getType();
                $name = $param->getName();

                if (! $type) throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                    );


                if ($type instanceof \ReflectionUnionType)  throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                    );


                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException(
                    'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
                );
            }, $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}