<?php

namespace Christophrumpel\NovaNotifications\Tests;

use Christophrumpel\NovaNotifications\NovaNotification;
use Christophrumpel\NovaNotifications\Tests\Models\TestModel;
use Illuminate\Support\Facades\Notification;

class NotificationControllerTest extends TestCase
{
    protected $notificationClassName;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->notificationClassName = 'Christophrumpel\NovaNotifications\Tests\Notifications\TestNotification';
        factory(TestModel::class)
            ->times(4)
            ->create();
    }

    /** @test * */
    public function it_returns_no_nova_notifications()
    {
        $this->get('nova-vendor/nova-notifications/notifications')
            ->assertSuccessful()
            ->assertJsonCount(0);
    }

    /** @test * */
    public function it_returns_given_nova_notifications()
    {
        $notifications = factory(NovaNotification::class)
            ->times(2)
            ->create();

        $this->get('nova-vendor/nova-notifications/notifications')
            ->assertSuccessful()
            ->assertJsonCount(2)
            ->assertJson([
                $notifications[0]->toArray(),
                $notifications[1]->toArray(),
            ]);
    }

    /** @test * */
    public function it_does_not_find_the_provided_notification_class()
    {
        $notificationData = [
            'notification' => ['name' => 'NotGivenNotification'],
            'notificationParameters' => [],
            'notifiable' => [
                'name' => 'App\User',
                'value' => '2',
            ],
        ];

        $this->post('nova-vendor/nova-notifications/notifications/send', $notificationData)
            ->assertStatus(400);
    }

    /** @test * */
    public function it_sends_a_notification()
    {
        $this->disableExceptionHandling();

        $notificationData = [
            'notification' => ['name' => $this->notificationClassName],
            'notificationParameters' => [],
            'notifiable' => [
                'name' => 'Christophrumpel\NovaNotifications\Tests\Models\TestModel',
                'value' => '2',
            ],
        ];

        $this->post('nova-vendor/nova-notifications/notifications/send', $notificationData)
            ->assertSuccessful();

        Notification::assertSentTo(TestModel::find(2), $this->notificationClassName);
    }

    /** @test * */
    public function it_sends_a_notification_with_wrong_notifiable_id()
    {
        $notificationData = [
            'notification' => ['name' => $this->notificationClassName],
            'notificationParameters' => [],
            'notifiable' => [
                'name' => 'Christophrumpel\NovaNotifications\Tests\Models\TestModel',
                'value' => '99',
            ],
        ];

        $this->post('nova-vendor/nova-notifications/notifications/send', $notificationData)
            ->assertStatus(404);
    }

    /** @test * */
    public function it_sends_a_notification_with_wrong_params()
    {
        $this->disableExceptionHandling();
        $notificationData = [
            'notification' => ['name' => $this->notificationClassName],
            'notificationParameters' => [
                [
                    'type' => 'int',
                    'value' => 'wrongInputType',
                ],
            ],
            'notifiable' => [
                'name' => 'Christophrumpel\NovaNotifications\Tests\TestModel',
                'value' => '99',
            ],
        ];

        $this->post('nova-vendor/nova-notifications/notifications/send', $notificationData)
            ->assertStatus(422);
    }
}
