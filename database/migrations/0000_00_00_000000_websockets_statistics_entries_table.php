<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WebSocketsStatisticsEntriesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('websockets_statistics_entries', function (Blueprint $table) {

            $table->increments('id');
            $table->string('app_id');

            $table->integer('peak_connections_count');
            $table->integer('websocket_messages_count');
            $table->integer('api_messages_count');

            $table->nullableTimestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websockets_statistics_entries');
    }
}