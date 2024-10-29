<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' =>   1, 'name'   =>   'Acts', 'user_id' => 1],
            ['id' =>   2, 'name'   =>   'Bills', 'user_id' => 1],
            ['id' =>   3, 'name'   =>   'Hansard', 'user_id' => 1],
            ['id' =>   4, 'name'   =>   'Order Paper', 'user_id' => 1],
            ['id' =>   5, 'name'   =>   'Votes and Proceedings', 'user_id' => 1],
            ['id' =>   6, 'name'   =>   'Magazines', 'user_id' => 1],
            ['id' =>   7, 'name'   =>   'Laws of Nigeria', 'user_id' => 1],
            ['id' =>   8, 'name'   =>   'Presidential Decrees', 'user_id' => 1],
            ['id' =>   9, 'name'   =>   'Audio', 'user_id' => 1],
            ['id' =>   10, 'name'   =>   'Videos', 'user_id' => 1],
            ['id' =>   11, 'name'   =>   'Journals', 'user_id' => 1],
        ];
        Category::insert($categories);
    }
}
