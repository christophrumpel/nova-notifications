<?php

namespace Christophrumpel\NovaNotifications;

use ReflectionClass;
use Illuminate\Support\Collection;

class ClassFinder
{

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->getAppNamespace();
    }

    /**
     * @param string $nameSpace
     * @return Collection
     */
    public function find(string $nameSpace): Collection
    {
        $composer = require base_path('vendor/autoload.php');

        return collect($composer->getClassMap())->filter(function ($value, $key) use ($nameSpace) {
                return starts_with($key, $nameSpace);
            });
    }

    /**
     * Find class who are extending a specific class
     * @param string $className
     * @return Collection
     */
    public function findByExtending(string $className): Collection
    {
        $composer = require base_path('vendor/autoload.php');

        return collect($composer->getClassMap())
            ->filter(function ($value, $key) {
                return starts_with($key, app()->getNamespace());
            })
            ->filter(function ($value, $key) use ($className) {
                try {
                    $classInfo = new ReflectionClass($key);
                } catch (\ReflectionException $e) {
                    return false;
                }

                return $classInfo->isSubclassOf($className);
            })->keys();
    }
}
