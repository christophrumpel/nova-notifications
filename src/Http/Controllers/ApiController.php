<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use Illuminate\Http\Response;
use ReflectionClass;

abstract class ApiController
{
    public function respondSuccess(): Response
    {
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function isEloquentModelClass(string $className)
    {
        try {
            $classInfo = new ReflectionClass($className);
        } catch (\ReflectionException $e) {
            return false;
        }

        return $classInfo->isSubclassOf('Illuminate\Database\Eloquent\Model');
    }
}
