<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        $this->call(roleSeeder::class);
        $this->call(usersTableSeeder::class);
        factory(App\User::class, 50)->create();
        factory(App\Product::class, 50)->create();
        factory(App\Order::class, 10)->create();
        $this->call(cuomerOrderSeeder::class);
        $products = \App\Product::all();
        App\User::all()->each(function ($user)  {
            $user->assignRole('user');
        });
        App\User::all()->each(function ($user) use ($products) {
            $user->usersCart()->attach(
                $products->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

    }

    private function cleanDatabase()
    {
        Schema::disableForeignKeyConstraints();

        collect(DB::select("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'"))
            ->map(function ($tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->reject(function (string $tableName) {
                return $tableName === 'migrations';
            })
            ->each(function (string $tableName) {
                DB::table($tableName)->truncate();
            });

        Schema::enableForeignKeyConstraints();
    }
}
