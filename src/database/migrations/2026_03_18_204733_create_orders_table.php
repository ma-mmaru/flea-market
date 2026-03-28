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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //1商品につき購入は1回のみの為unique()
            $table->foreignId('item_id')->unique()->constrained()->cascadeOnDelete();
            //購入したユーザー
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //支払い方法(コンビニ、カードetc..)
            $table->string('payment_method');
            //配送先住所
            $table->string('shipping_postal_code', 8);
            $table->string('shipping_address');
            $table->string('shipping_building')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};