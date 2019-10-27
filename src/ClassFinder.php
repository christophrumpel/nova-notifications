<?php

namespace Christophrumpel\NovaNotifications;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class ClassFinder
{
    /**
     * @return mixedt
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
            return Str::startsWith($key, $nameSpace);
        });
    }

    /**
     * Find classes which are extending a specific class.
     *
     * @param string $classNameToFind
     * @param array $namespacesToSearch
     * @return Collection
     */
    public function findByExtending(string $classNameToFind, array $namespacesToSearch): Collection
    {
        $composer = require base_path('vendor/autoload.php');

        return collect($composer->getClassMap())
            ->keys()
            ->filter(function ($className) {
                return $className !== 'Illuminate\Filesystem\Cache';
            })
            ->filter(function ($className) use ($namespacesToSearch) {
                return collect($namespacesToSearch)
                    ->filter(function ($namespace) use ($className) {
                        return Str::startsWith($className, $namespace);
                    })
                    ->count();
            })
            ->filter(function ($className) use ($classNameToFind) {
                try {
                    $classInfo = new ReflectionClass($className);
                } catch (\Exception $e) {
                    return false;
                }

                return $classInfo->isSubclassOf($classNameToFind);
            });
    }
}
