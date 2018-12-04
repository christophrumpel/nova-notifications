<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use stdClass;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Christophrumpel\NovaNotifications\ClassFinder;

class NotificationClassesController extends ApiController
{
    /**
     * @var ClassFinder
     */
    private $classFinder;

    /**
     * NotificationClassesController constructor.
     *
     * @param ClassFinder $classFinder
     */
    public function __construct(ClassFinder $classFinder)
    {
        $this->classFinder = $classFinder;
    }

    public function index()
    {
        return $this->classFinder->findByExtending('Illuminate\Notifications\Notification', config('nova-notifications.notificationNamespaces'))
            ->map(function ($className) {
                try {
                    $classInfo = new ReflectionMethod($className, '__construct');
                } catch (\ReflectionException $e) {
                    return [
                        'name' => $className,
                        'parameters' => [],
                    ];
                }

                $notificationClassInfo = new stdClass();
                $notificationClassInfo->name = $classInfo->class;

                $params = collect($classInfo->getParameters())->map(function (ReflectionParameter $param) {
                    $paramTypeName = is_null($param->getType()) ? 'unknown' : $param->getType()
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
                        'type' => $paramTypeName,
                        'options' => $options ?? '',
                    ];
                });

                $notificationClassInfo->parameters = $params;

                return $notificationClassInfo;
            })->values();
    }
}
