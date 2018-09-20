<?php

namespace Christophrumpel\NovaNotifications\Tests;

use Mockery;
use Christophrumpel\NovaNotifications\ClassFinder;

class NotifiableControllerTest extends TestCase
{
    /**
     * @test
     **/
    public function it_returns_no_results()
    {
        $classFinder = Mockery::mock(ClassFinder::class);
        $this->app->instance(ClassFinder::class, $classFinder);

        $classFinder->shouldReceive('find')
            ->withArgs([config('nova-notifications.modelNamespace')])
            ->andReturn(collect([]));

        $response = $this->get('nova-vendor/nova-notifications/notifiables')
            ->assertSuccessful();

        $output = json_decode($response->getContent());
        $this->assertEmpty($output->data);
    }

    /**
     * @test
     **/
    public function it_returns_given_notifiable()
    {
        $testModelClassName = 'Christophrumpel\NovaNotifications\Tests\Models\TestModel';
        $testModelClassNameDots = str_replace('\\', '.', $testModelClassName);
        $classFinder = Mockery::mock(ClassFinder::class);
        $this->app->instance(ClassFinder::class, $classFinder);

        $classFinder->shouldReceive('find')
            ->withArgs([config('nova-notifications.modelNamespace')])
            ->andReturn(collect([$testModelClassName => 'path/to/file']));

        $response = $this->get('nova-vendor/nova-notifications/notifiables')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    $testModelClassName => [
                        'name' => $testModelClassNameDots,
                        'options' => [],
                    ],
                ],
                'filter' => [
                    'name' => 'Notifiables',
                    'options' => [
                        $testModelClassName => [
                            'name' => $testModelClassNameDots,
                        ],
                    ],
                ],
            ]);
    }
}
