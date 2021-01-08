<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Episode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();
         Course::factory(50)->create();
         Episode::factory(150)->create();
    }
}
