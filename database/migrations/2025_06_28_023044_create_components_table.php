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
            $table->string('name')->unique()->index()->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('condition_id')->nullable()->index();
            $table->unsignedBigInteger('manufacturer_id')->nullable()->index();
            $table->unsignedBigInteger('status_id')->nullable()->index();

            $table->text('stockin_source')->nullable();
            // Tại sao không để trường này trong component log? Bởi nó luôn luôn bắt buộc khi thêm một component
            // Không cho phép sửa đổi trường này nếu không đủ thẩm quyền, đảm bảo tính toàn vẹn của dữ liệu 
            $table->timestamp('stockin_at')->index(); // Ngày nhập kho dành cho nghiệp vụ nhập (nếu có)

            $table->timestamp('warranty_start')->nullable()->index();
            $table->timestamp('warranty_end')->nullable()->index();
            $table->text('note')->nullable();

            $table->timestamps(); // Thêm index thủ công cho $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');

            //WHERE category = ? AND vendor = ? AND condition = ? AND location = ? for fastest query
            $table->index(['category_id', 'condition_id', 'manufacturer_id'], 'index_category_condition_manufacturer');
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
