<?php

namespace Database\Seeders;

use App\Models\Penumpang;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Penumpang::factory(1000)->create();
        User::factory(100)->create();


        $this->call([
            UserSeeder::class,
        ]);
    }
}
