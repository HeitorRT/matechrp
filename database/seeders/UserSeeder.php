<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->hasAttached(Role::first())
            ->has(Address::factory())
            ->admin()
            ->teacher()
            ->partner()
            ->create();

        User::factory(10)
            ->hasAttached(Role::all()->random())
            ->has(Address::factory())
            ->teacher()
            ->create();

        User::factory(10)
            ->hasAttached(Role::all()->random())
            ->has(Address::factory())
            ->partner()
            ->create();
    }
}
