<?php

namespace Database\Seeders;

use App\Models\JobTypeModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\New_;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=4; $i++){
        $jobType= new JobTypeModel;
        $jobType->name='abhishek';
        $jobType->save();
    }
}
}
