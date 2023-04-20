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
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->timestamps();

            $table->index(["created_at"]);
        });

        $names = [
            "pending",
            "awaiting_payment",
            "printing",
            "cancelled_by_user",
            "cancelled_by_manf",
            "shipped",
            "finished",
        ];

        foreach ($names as $name) {
            $orderStatus = new \App\Models\OrderStatus;
            $orderStatus->name = $name;
            $orderStatus->save();
        }
    }

    public function down(): void {
        Schema::dropIfExists('order_order_statuses');
    }
};
