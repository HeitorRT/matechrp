<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Installment;
use App\Models\Order;
use App\Models\Student;
use Illuminate\Database\Seeder;

class InstallmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Installment::factory(30)
            ->state(function() {
                return [
                    'order_id' => Order::all()->random()->id,
                    'intstallment_number' => rand(1,3),
                ];
            })
            ->create();
    }
}
