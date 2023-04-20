<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->timestamps();
        });

        $user = $this->createUserGroup("user");
        $admin = $this->createUserGroup("admin");
    }

    protected function createUserGroup(string $name) {
        $userGroup = new \App\Models\UserGroup;
        $userGroup->name = $name;
        $userGroup->save();
        return $userGroup;
    }

    public function down(): void {
        Schema::dropIfExists('user_groups');
    }
};
