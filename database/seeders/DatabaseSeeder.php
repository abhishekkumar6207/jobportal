<?php

namespace Database\Seeders;

use App\Models\PostJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // CategoryModel::factory(5)->create();
        // JobTypeModel::factory(5)->create();

        $this->call([
            CategoriesSeeder::class,
            JobTypeSeeder::class,
            jobSeeder::class


        ]);


    }
}
