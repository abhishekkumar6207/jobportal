<?php

namespace Database\Seeders;
use App\Models\CategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=4; $i++){
        $category= new CategoryModel;
        $category->name='abhishek';
        $category->save();
    }
}
}
