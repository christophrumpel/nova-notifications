<?php

namespace Christophrumpel\NovaNotifications;

use Illuminate\Database\Eloquent\Model;

class NovaNotification extends Model
{
    protected $fillable = ['notification', 'notifiable_type', 'notifiable_id', 'channel', 'failed'];
}
