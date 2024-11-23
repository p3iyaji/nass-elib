<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Acts', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 2, 'name' => 'Bills', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 3, 'name' => 'Hansard', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 4, 'name' => 'Order Paper', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 5, 'name' => 'Votes and Proceedings', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 6, 'name' => 'Magazines', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 7, 'name' => 'Laws of Nigeria', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 8, 'name' => 'Presidential Decrees', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 9, 'name' => 'Audio', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 10, 'name' => 'Videos', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
            ['id' => 11, 'name' => 'Journals', 'slug' => Str::slug('name', '-'), 'user_id' => 1],
        ];
        Category::insert($categories);
    }
}
