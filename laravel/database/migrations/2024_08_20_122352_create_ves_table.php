<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ves', function (Blueprint $table) {
            $table->id();
            $table->string('ma_ghe');
            $table->string('ma_chuyen');
            $table->decimal('gia_ve', 8, 2);
            $table->string('ten_hanh_khach');
            $table->string('so_dien_thoai');
            $table->string('ma_the')->nullable();
            $table->mediumInteger('cvv')->nullable();
            $table->enum('trang_thai_thanh_toan', ['KHONG_XAC_DINH','DANG_THANH_TOAN','DA_THANH_TOAN'])->default('KHONG_XAC_DINH');
            $table->enum('trang_thai_gui_mail', ['KHONG_XAC_DINH','DANG_GUI','DA_GUI'])->default('KHONG_XAC_DINH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ves');
    }
};
