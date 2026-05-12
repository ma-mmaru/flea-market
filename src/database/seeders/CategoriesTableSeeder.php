<?php

namespace Database\Seeders;

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
            ['name' => 'キッチン'],
            ['name' => 'コスメ'],
            ['name' => '本'],
            ['name' => 'ゲーム'],
            ['name' => 'スポーツ'],
            ['name' => 'ハンドメイド'],
            ['name' => 'アクセサリー'],
            ['name' => 'おもちゃ'],
            ['name' => 'ベビー・キッズ'],
        ];
        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']]);
        }
    }
}