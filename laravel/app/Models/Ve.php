<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_ghe',
        'ma_chuyen',
        'gia_ve',
        'ten_hanh_khach',
        'so_dien_thoai',
        'ma_the',
        'cvv',
        'trang_thai_thanh_toan',
        'trang_thai_gui_mail'
    ];
}
