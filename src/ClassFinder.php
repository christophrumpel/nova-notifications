<?php

namespace Christophrumpel\NovaNotifications;

use Illuminate\Support\Collection;

class ClassFinder
{
    /**
     * @param string $nameSpace
     * @return Collection
     */
    public function find(string $nameSpace): Collection
    {
        $composer = require base_path('vendor/autoload.php');

        return collect($composer->getClassMap())
            ->filter(function ($value, $key) use ($nameSpace) {
                return starts_with($key, $nameSpace);
            });
    }
}
