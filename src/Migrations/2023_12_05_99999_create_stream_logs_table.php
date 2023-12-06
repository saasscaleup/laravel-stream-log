<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_logs', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('message');
            $table->string('event', 50);
            $table->string('type', 50);
            $table->boolean('delivered')->default(0);
            $table->string('client', 50)->nullable();
            $table->timestamps();
        });

        Schema::table('stream_logs', static function (Blueprint $table) {
            $table->index(['client','delivered']);
            $table->index(['delivered']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stream_logs');
    }
}
