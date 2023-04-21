<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('order_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Order::class)->constrained();
            $table->foreignIdFor(\App\Models\OrderStatus::class)->constrained();
            $table->text("comment");
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->timestamps();

            $table->index(["created_at"]);
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_order_statuses');
    }
};
