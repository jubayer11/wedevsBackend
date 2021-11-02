<?php

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
        DB::table('users')->insert([
            [
                'email' => 'admin@wedevs.com',
                'password' => Hash::make('password'),
                'name' => 'jubayer',
            ],
        ])
//            ->each(function ($item) {
//            User::create($item)->assignRole('admin');
//        })
        ;

    }
}
