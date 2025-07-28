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
        Schema::create('component_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('component_id')->index(); // Mã linh kiện thao tác nghiệp vụ

            $table->unsignedBigInteger('user_id')->nullable()->index(); // Người thực hiện nghiệp vụ
            $table->unsignedBigInteger('action_id')->nullable()->index(); // Loại nghiệp vụ

            $table->unsignedBigInteger('customer_id')->nullable()->index(); // Khách liên quan nghiệp vụ
            $table->unsignedBigInteger('vendor_id')->nullable()->index(); // Nhà cung cấp liên quan nghiệp vụ
            $table->unsignedBigInteger('location_id')->nullable()->index(); // Vị trí đặt liên quan nghiệp vụ

            $table->string('note')->nullable(); // Mô tả nội dung thực hiện nghiệp vụ

            $table->timestamp('stockout_at')->nullable()->index(); // Ngày xuất kho dành cho nghiệp vụ xuất (nếu có)
            $table->timestamp('stockreturn_at')->nullable()->index(); // Ngày thu hồi dành cho nghiệp vụ thu hồi (nếu có)

            $table->timestamps(); // Thêm index thủ công cho $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
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
