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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        $names = [
            "pending",
            "awaiting-payment",
            "printing",
            "cancelled-by-user",
            "cancelled-by-manf",
            "shipped",
            "finished",
        ];

        foreach ($names as $name) {
            $orderStatus = new \App\Models\OrderStatus;
            $orderStatus->name = $name;
            $orderStatus->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
