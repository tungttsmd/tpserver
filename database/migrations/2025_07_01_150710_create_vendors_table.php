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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('phone')->nullable()->index();
            $table->string('email')->index();
            $table->string('address')->index();
            $table->string('note');
            $table->timestamp('date_updated')->useCurrent()->useCurrentOnUpdate()->index();
            $table->timestamp('date_created')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
