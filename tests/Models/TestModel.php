<?php

namespace Christophrumpel\NovaNotifications\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TestModel extends Model
{
    use Notifiable;
}
