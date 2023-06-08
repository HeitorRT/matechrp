<?php

namespace Database\Seeders;

use App\Models\Indication;
use Illuminate\Database\Seeder;

class IndicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Indication::factory(random_int(10, 20))->create();
    }
}
