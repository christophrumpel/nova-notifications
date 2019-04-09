<?php

namespace Christophrumpel\NovaNotifications\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationController extends ApiController
{
    public function index()
    {
        return DB::table('nova_notifications')
            ->orderBy('id','desc')
            ->get();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $notificationClass = $request->get('notification')['name'];
        $params = collect($request->get('notificationParameters'))->map(function ($param) {
            if ($this->isEloquentModelClass($param['type'])) {
                return $param['type']::findOrFail($param['value']);
            }

            return $param['value'];
        });

        if (! class_exists($notificationClass)) {
            return response('', 400);
        }

        try {
            $notification = $params ? new $notificationClass(...$params) : new $notificationClass();
        } catch (\Throwable $e) {
            return response(__('The notification could not be created with the provided information'), 422);
        }

        $notifiable = str_replace('.', '\\', $request->get('notifiable')['name']);

        Notification::send($notifiable::findOrFail($request->get('notifiable')['value']), $notification);

        $this->respondSuccess();
    }
}
