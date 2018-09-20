<?php

namespace Christophrumpel\NovaNotifications\Tests;

use Christophrumpel\NovaNotifications\NovaNotification;

class NotificationStatsControllerTest extends TestCase
{
    /** @test * */
    public function it_returns_empty_stats_for_no_nova_notifications()
    {
        $this->get('nova-vendor/nova-notifications/notifications/stats')
            ->assertSuccessful();
    }

    /** @test * */
    public function it_returns_stats_for_nova_notifications()
    {
        factory(NovaNotification::class)
            ->times(2)
            ->create();

        factory(NovaNotification::class)->create([
           'failed' => true,
        ]);

        $this->get('nova-vendor/nova-notifications/notifications/stats')
            ->assertSuccessful()
            ->assertJson([
                'all' => 3,
                'failed' => 1,
            ]);
    }
}
