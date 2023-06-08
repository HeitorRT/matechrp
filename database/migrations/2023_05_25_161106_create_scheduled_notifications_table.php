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
        Schema::create('scheduled_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('notification_id')->constrained('notifications');
            $table->dateTime('send_at_by_sms')->nullable();
            $table->dateTime('send_at_by_whatsapp')->nullable();
            $table->dateTime('send_at_by_email')->nullable();
            $table->dateTime('send_at_by_pusher')->nullable();
            $table->dateTime('read_at_by_system')->nullable();
            $table->morphs('scheduledable', 'scheduledable_scheduledable_type_scheduledable_id_index');
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
        Schema::dropIfExists('scheduled_notifications');
    }
};
