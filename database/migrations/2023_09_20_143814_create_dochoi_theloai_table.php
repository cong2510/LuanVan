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
        Schema::create('sanpham_theloai', function (Blueprint $table) {
            $table->id();
            $table->integer("sanpham_id");
            $table->integer("theloai_id");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('sanpham_id')->references('id')->on('sanpham');
            $table->foreign('theloai_id')->references('id')->on('theloai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dochoi_theloai');
    }
};
