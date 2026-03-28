<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories_items', function (Blueprint $table) {
            $table->id();
            //商品が削除されたら紐付けデータも自動で削除する
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            //カテゴリが削除されたら紐付けデータも自動で削除する
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            //同じ商品に同じカテゴリを２回登録できないようにする
            $table->unique(['item_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_items');
    }
};