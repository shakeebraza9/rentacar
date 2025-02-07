<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::create([
            'image_id' => 'img1.jpg',
            'title' => 'First Blog Title',
            'description' => 'This is the description for the first blog.',
            'short_description' => 'Short description for the first blog.',
            'user_id' => 1,
            'location' => 'New York',
        ]);

        Blog::create([
            'image_id' => 'img2.jpg',
            'title' => 'Second Blog Title',
            'description' => 'This is the description for the second blog.',
            'short_description' => 'Short description for the second blog.',
            'user_id' => 2,
            'location' => 'London',
        ]);
    }
}

