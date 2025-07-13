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
        Schema::create('profile_role_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->unique()->index();
            $table->string('hexcode')->unique()->index();

            $table->timestamps(); // Thêm index thủ công cho $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_role_colors');
    }
};
