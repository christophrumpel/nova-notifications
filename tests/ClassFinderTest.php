<?php

namespace Christophrumpel\NovaNotifications\tests;

use Christophrumpel\NovaNotifications\ClassFinder;

class ClassFinderTest extends TestCase
{
    /**
     * @test
     **/
    public function it_find_classes()
    {
        $this->app->setBasePath(__DIR__.'/..');

        $classFinder = app(ClassFinder::class);

        $response = $classFinder->find('Illuminate\Database\Eloquent\Model', ['App']);

        $this->assertInstanceOf('Illuminate\Support\Collection', $response);
    }

    /**
     * @test
     **/
    public function it_find_classes_which_are_extending_a_specific_class()
    {
        $this->app->setBasePath(__DIR__.'/..');

        $classFinder = app(ClassFinder::class);

        $response = $classFinder->findByExtending('Illuminate\Database\Eloquent\Model', ['App']);

        $this->assertInstanceOf('Illuminate\Support\Collection', $response);
    }
}
