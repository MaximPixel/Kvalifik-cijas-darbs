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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->boolean("deleted")->default(false);
            $table->foreignIdFor(\App\Models\Printer::class, "parent_printer_id")->nullable()->constrained("printers")->nullOnDelete();
            $table->string("name");
            $table->text("description");
            $table->string("manufacturer");
            $table->foreignIdFor(\App\Models\User::class, "creator_user_id")->nullable()->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
