<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique()->index();
            $table->string('category')->index();
            $table->string('vendor')->index();
            $table->string(column: 'condition')->index();
            $table->string('location')->index();
            $table->string('status');
            $table->text('description');
            $table->timestamp('warranty_expiry_at')->nullable();
            $table->timestamp(column: 'imported_at')->nullable();
            $table->timestamp('exported_at')->nullable();
            $table->timestamp('recalled_at')->nullable();
            $table->timestamps();
            $table->index(['category', 'vendor', 'condition', 'location'], 'idx_category_vendor_condition_location');
            //WHERE category = ? AND vendor = ? AND condition = ? AND location = ? for fastest query
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
};
