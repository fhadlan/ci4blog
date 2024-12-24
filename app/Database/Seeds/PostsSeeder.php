<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $data = [];
        $words = implode(',', $faker->words(rand(1, 5)));
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'author_id' => 1,
                'title' => $faker->sentence,
                'slug' => $faker->slug,
                'category_id' => rand(1, 3),
                'image' => "",
                'content' => $faker->paragraph,
                'visibility' => 1,
                'tags' => $words,
                'meta_keywords' => $words,
                'meta_description' => $faker->sentence
            ];
        }
        $this->db->table('posts')->insertBatch($data);
    }
}
