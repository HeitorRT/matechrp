<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SystemSettingSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            StudentSeeder::class,
            CategorySeeder::class,
            GenreSeeder::class,
            SectionSeeder::class,
            ContentSeeder::class,
            LiveEventSeeder::class,
            MeetingSeeder::class,
            JobVacancySeeder::class,
            IndicationSeeder::class,
            CampaignSeeder::class,
            CommonQuestionSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            ItemSeeder::class,
            QuizzSeeder::class,
            PopupSeeder::class,
            NotificationSeeder::class,
            ScheduledNotificationSeeder::class,
            InstallmentSeeder::class,
        ]);
    }
}
