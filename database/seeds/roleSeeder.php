<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions.
        app()['cache']->forget('spatie.permission.cache');

        // Create Roles.
        collect([
            [
                'role' => [
                    'name' => 'admin',
                ],
            ],
            [
                'role' => [
                    'name' => 'User',
                ],

            ],

        ])->each(function ($item) {
            Role::create($item['role']);
        });
    }

}
