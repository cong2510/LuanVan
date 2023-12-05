<?php

use App\Models\PromoCode;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promocode', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->integer('value')->nullable();
            $table->integer('max_usage');
            $table->integer('max_usage_per_users');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('promo_status', PromoCode::PROMO_STATUS)->default(PromoCode::PROMO_STATUS[0]);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocode');
    }
};
