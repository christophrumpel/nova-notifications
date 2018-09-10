<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use stdClass;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Christophrumpel\NovaNotifications\ClassFinder;

class NotificationClassesController extends  ApiController {
    /**
     * @var ClassFinder
     */
    private $classFinder;

    /**
     * NotificationClassesController constructor.
     *
     * @param ClassFinder $classFinder
     */
    public function __construct(ClassFinder $classFinder) {

        $this->classFinder = $classFinder;
    }

    public function index()
    {

        return $this->classFinder->find(config('nova-notifications.notificationNamespace'))
            ->map(function ($path, $className) {
                return $className;
            })
            ->map(function ($className) {
                $classInfo = new ReflectionMethod($className, '__construct');
                $notificationClassInfo = new stdClass();
                $notificationClassInfo->name = $classInfo->class;

                $params = collect($classInfo->getParameters())->map(function (ReflectionParameter $param) {
                    $paramTypeName = $param->getType()
                        ->getName();

                    if (class_exists($paramTypeName)) {

                        $class = new ReflectionClass($paramTypeName);
                        $fullyClassName = $class->getName();

                        if ($this->isEloquentModelClass($fullyClassName)) {
                            $options = collect($fullyClassName::all())->map(function ($item) {
                                return [
                                    'id' => $item->id,
                                    'name' => $item->name ?? $item->id,
                                ];
                            });
                        }

                    }

                    return [
                        'name' => $param->getName(),
                        'type' => $param->getType()
                            ->getName(),
                        'options' => $options ?? '',
                    ];
                });

                $notificationClassInfo->parameters = $params;

                return $notificationClassInfo;
            });
    }

}