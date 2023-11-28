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
        Schema::create('sanpham_favorite', function (Blueprint $table) {
            $table->id();
            $table->integer("sanpham_id");
            $table->integer("favorite_id");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('sanpham_id')->references('id')->on('sanpham');
            $table->foreign('favorite_id')->references('id')->on('favorite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham_favorite');
    }
};
