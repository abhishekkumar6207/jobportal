<?php

namespace Database\Seeders;

use App\Models\PostJob;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class jobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    {
        for($i=1; $i<=10; $i++){
            $postJob = new PostJob;
            $postJob->title = 'code';
            $postJob->category_id =1;
            $postJob->job_type_id =1;
            $postJob->user_id = '1';
            $postJob->vacancy = '1';
            $postJob->salary = '20k';
            $postJob->location = 'patna';
            $postJob->description = 'dummy';
            $postJob->benefits = 'dummy';
            $postJob->responsibility = 'dummy';
            $postJob->qualifications = 'dummy';
            $postJob->experience = '2 years';
            $postJob->keywords = 'laravel';
            $postJob->company_name = 'edugaon';
            $postJob->company_location = 'patna';
            $postJob->company_website = 'xyz.com';
            $postJob->save();
    }
}
    }
}
