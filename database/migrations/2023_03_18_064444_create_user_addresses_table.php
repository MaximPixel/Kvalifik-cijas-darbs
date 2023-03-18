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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->string("contact_name");
            $table->string("phone_number_prefix");
            $table->string("phone_number");
            $table->string("address_street");
            $table->string("address_apt");
            $table->string("address_province");
            $table->string("address_city");
            $table->string("address_zipcode");
            $table->string("comment");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
