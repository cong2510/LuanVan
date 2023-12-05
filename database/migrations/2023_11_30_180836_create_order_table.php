<?php

use App\Models\Order;
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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("promocode_id");
            $table->string("email",100);
            $table->string("diachi",300);
            $table->string("phone",10);
            $table->double("totalprice");
            $table->enum('order_status', Order::ORDER_STATUS)->default(Order::ORDER_STATUS[0]);
            $table->string('order_id_ref')->nullable(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('promocode_id')->references('id')->on('promocode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
