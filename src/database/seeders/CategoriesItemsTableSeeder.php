<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class CategoriesItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //腕時計
        $item1 = Item::find(1);
        if ($item1) $item1->categories()->attach([1, 2]);
        //HDD
        $item2 = Item::find(2);
        if ($item2) $item2->categories()->attach([4]);
        //玉ねぎ
        $item3 = Item::find(3);
        if ($item3) $item3->categories()->attach([6]);
        //革靴
        $item4 = Item::find(4);
        if ($item4) $item4->categories()->attach([1, 2]);
        //ノートPC
        $item5 = Item::find(5);
        if ($item5) $item5->categories()->attach([4]);
        //マイク
        $item6 = Item::find(6);
        if ($item6) $item6->categories()->attach([4]);
        //ショルダーバッグ
        $item7 = Item::find(7);
        if ($item7) $item7->categories()->attach([1, 3]);
        //タンブラー
        $item8 = Item::find(8);
        if ($item8) $item8->categories()->attach([7]);
        //コーヒーミル
        $item9 = Item::find(9);
        if ($item9) $item9->categories()->attach([7]);
        //メイクセット
        $item10 = Item::find(10);
        if ($item10) $item10->categories()->attach([3, 8]);
    }
}