<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        collect([
            [
                'name' => 'jubayer',
                'email' => 'admin@wedevs.com',
                'password' => Hash::make('password'),
                'isStaff' => 1,
            ],
        ])->each(function ($item) {
            User::create($item)->assignRole('admin');
        });

    }
}
