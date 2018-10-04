<?php

namespace Christophrumpel\NovaNotifications\Tests;

use Mockery;
use Christophrumpel\NovaNotifications\ClassFinder;

class NotificationClassesControllerTest extends TestCase
{
    protected $testNotificationClassName;

    protected $classFinder;

    public function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();

        $this->testNotificationClassName = 'Christophrumpel\NovaNotifications\Tests\Notifications\TestNotification';

        $this->classFinder = Mockery::mock(ClassFinder::class);
        $this->app->instance(ClassFinder::class, $this->classFinder);
    }

    /**
     * @test
     **/
    public function it_returns_given_notification_classes()
    {
        $this->classFinder->shouldReceive('find')
            ->withArgs(['Christophrumpel\NovaNotifications\Tests\Notifications'])
            ->andReturn(collect([$this->testNotificationClassName => 'path/to/file']));

        $this->get('nova-vendor/nova-notifications/notifications/classes')
            ->assertSuccessful()
            ->assertJson([
                [
                    'name' => $this->testNotificationClassName,
                    'parameters' => [
                        [
                            'name' => 'testParam',
                            'type' => 'int',
                            'options' => '',
                        ],
                    ],
                ],
            ]);
    }
}
