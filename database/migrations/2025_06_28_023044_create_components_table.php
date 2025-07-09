<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique()->index();
            $table->string('name')->unique()->index()->nullable();
            $table->unsignedBigInteger('category_id')->index();

            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->unsignedBigInteger('condition_id')->index()->nullable();
            $table->unsignedBigInteger('location_id')->index()->nullable();
            $table->unsignedBigInteger('manufacturer_id')->index()->nullable();
            $table->unsignedBigInteger('status_id')->index()->nullable();
            $table->text('note')->nullable();
            $table->timestamp('warranty_start')->nullable()->index();
            $table->timestamp('warranty_end')->nullable()->index();
            $table->timestamp('date_updated')->useCurrent()->useCurrentOnUpdate()->index();
            $table->timestamp('date_created')->useCurrent()->index();


            $table->index(['category_id', 'vendor_id', 'condition_id', 'location_id', 'manufacturer_id'], 'idx_category_vendor_condition_locationmanufacturer');
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
