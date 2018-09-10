<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovaNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification');
            $table->string('notifiable_type');
            $table->string('notifiable_id');
            $table->string('channel');
            $table->boolean('failed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_notifications');
    }
}
