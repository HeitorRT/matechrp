<?php

namespace Database\Seeders;

use App\Models\LiveEvent;
use App\Models\Notification;
use App\Models\ScheduledNotification;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ScheduledNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScheduledNotification::factory(10)
            ->state(function() {
                return [
                    'student_id' => Student::first()->id,
                    'notification_id' => Notification::all()->random()->id,
                    'scheduledable_type' => LiveEvent::class,
                    'scheduledable_id' => LiveEvent::all()->random()->id,
                ];
            })
            ->create();
    }
}
