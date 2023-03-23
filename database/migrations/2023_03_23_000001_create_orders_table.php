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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->boolean("deleted")->default(false);
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->foreignIdFor(\App\Models\UserAddress::class)->constrained();
            $table->foreignIdFor(\App\Models\ManfService::class)->constrained();
            $table->foreignIdFor(\App\Models\PrintModel::class)->constrained();
            $table->foreignIdFor(\App\Models\PrintMaterialColor::class)->constrained();
            $table->unsignedInteger("amount");
            $table->string("comment")->nullable();
            $table->unsignedBigInteger("print_time")->nullable();
            $table->foreignIdFor(\App\Models\OrderStatus::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
