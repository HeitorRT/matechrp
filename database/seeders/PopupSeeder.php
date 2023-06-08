<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Popup;
use Illuminate\Database\Seeder;

class PopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Popup::factory(20)
            ->create();
    }
}
