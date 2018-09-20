<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use Illuminate\Support\Facades\DB;

class NotificationStatsController
{
    public function index()
    {
        return [
            'all' => $this->getNotificationsCount(),
            'failed' => $this->getFailedNotificationsCount(),
        ];
    }

    private function getNotificationsCount()
    {
        return DB::table('nova_notifications')
            ->count();
    }

    private function getFailedNotificationsCount()
    {
        return DB::table('nova_notifications')
            ->where('failed', true)
            ->count();
    }
}
