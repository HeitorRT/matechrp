<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('name');
            $table->boolean('mandatory')->default(false);
            $table->boolean('send_by_pusher')->default(false);
            $table->boolean('send_by_email')->default(false);
            $table->boolean('send_by_sms')->default(false);
            $table->boolean('send_by_whatsapp')->default(false);
            $table->longText('content_pusher')->nullable();
            $table->longText('content_email')->nullable();
            $table->longText('content_sms')->nullable();
            $table->longText('content_whatsapp')->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('notifications');
    }
};
