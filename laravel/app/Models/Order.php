<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'products',
        'total_price',
        'status',
        'shipping_address',
        'billing_address'
    ];

    protected $casts = [
        'products' => 'array' // Chuyển đổi cột 'products' thành mảng khi lấy dữ liệu
    ];

    // Định nghĩa relationships nếu cần
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
