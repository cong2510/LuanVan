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
        Schema::create('sanpham', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id');
            $table->integer('discount_id');
            $table->string("name",1000);
            $table->string("mota",1000);
            $table->double("gia");
            $table->double("soluong");
            $table->boolean("tinhtrang")->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('brand_id')->references('id')->on('brand');
            $table->foreign('discount_id')->references('id')->on('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham');
    }
};
