<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use Christophrumpel\NovaNotifications\ClassFinder;
use ReflectionClass;

class NotifiableController extends ApiController
{

    /**
     * @var ClassFinder
     */
    private $classFinder;

    /**
     * NotifiableController constructor.
     *
     * @param ClassFinder $classFinder
     */
    public function __construct(ClassFinder $classFinder)
    {

        $this->classFinder = $classFinder;
    }

    public function index()
    {
        $modelClasses = $this->classFinder->find(config('nova-notifications.modelNamespace'))
            ->filter(function ($path, $className) {
                $classInfo = new ReflectionClass($className);


                return $classInfo->isSubclassOf('Illuminate\Database\Eloquent\Model') && in_array('Illuminate\Notifications\Notifiable',
                        $classInfo->getTraitNames());
            })
            ->map(function ($path, $className) {
                return [
                    'name' => str_replace('\\', '.', $className),
                    'options' => $className::all(),
                ];
            });

        $options = $modelClasses->map(function ($notifiable) {
            return [
                'name' => $notifiable['name'],
            ];
        })
            ->toArray();

        return [
            'data' => $modelClasses,
            'filter' => [
                'name' => 'Notifiables',
                'options' => $options,
            ],
        ];
    }

}

