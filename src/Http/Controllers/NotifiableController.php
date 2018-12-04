<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use ReflectionClass;
use Christophrumpel\NovaNotifications\ClassFinder;

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
        $modelClasses = $this->classFinder->findByExtending('Illuminate\Database\Eloquent\Model', config('nova-notifications.notifiableNamespaces'))
            ->filter(function ($className) {
                $classInfo = new ReflectionClass($className);

                return in_array('Illuminate\Notifications\Notifiable', $classInfo->getTraitNames());
            })
            ->map(function ($className) {
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
            'data' => $modelClasses->values(),
            'filter' => [
                'name' => __('Notifiables'),
                'options' => $options,
            ],
        ];
    }
}
