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
        Schema::create('rating', function (Blueprint $table) {
            $table->id();
            $table->integer("sanpham_id");
            $table->integer("user_id");
            $table->integer("orderdetail_id");
            $table->string("content",255);
            $table->integer("rating");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('sanpham_id')->references('id')->on('sanpham');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('orderdetail_id')->references('id')->on('order_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
