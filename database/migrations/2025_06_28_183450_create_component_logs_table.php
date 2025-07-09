<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('component_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('action_id');
            $table->string('note');
            $table->timestamp('date_issued')->nullable();
            $table->timestamp('date_recalled')->nullable();
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
        Schema::dropIfExists('component_logs');
    }
};
