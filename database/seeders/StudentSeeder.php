<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory()
            ->has(Address::factory())
            ->forTest()
            ->create();

        Student::factory(random_int(20, 40))
            ->has(Address::factory())
            ->create();

        Student::factory(random_int(20, 40))
            ->has(Address::factory())
            ->equalData()
            ->create();
    }
}
