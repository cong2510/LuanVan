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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('name')->nullable(false);
            $table->string('email')->nullable(false)->unique();
            $table->string('google_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->rememberToken();
            $table->string('address')->nullable();
            $table->boolean('gender')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
