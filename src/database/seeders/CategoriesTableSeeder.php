<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'ファッション'],
            ['name' => 'メンズ'],
            ['name' => 'レディース'],
            ['name' => '家電'],
            ['name' => 'インテリア'],
            ['name' => '野菜'],
            ['name' => '生活用品'],
            ['name' => '化粧品'],
        ];
        foreach ($categories as $category){
            Category::firstOrCreate(['name' => $category['name']]);
        }
    }
}