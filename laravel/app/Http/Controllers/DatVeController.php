<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Ve;
use App\Events\VeDaDat;
use Junges\Kafka\Facades\Kafka;

class DatVeController extends Controller
{
    public function datVe(Request $request)
    {
        // Validate
        $request->validate([
            // ...
        ]);
    
        $key = $request->ma_ghe . ':' . $request->ma_chuyen . ':' . $request->so_dien_thoai;
        
        if (Redis::exists($key)) {
            return response()->json(['error' => 'Vé đã được đặt'], 409);
        }
    
        Redis::set($key, true); // Đặt giá trị 
        Redis::expire($key, 60); // Thiết lập thời gian hết hạn là 60 giây
    
        $ve = Ve::create($request->all());

        // Pub sự kiện "đặt vé thành công"
        Kafka::publish()
        ->onTopic('dat_ve_thanh_cong')
        ->withBodyKey($ve->id,json_encode($request->all()))
        ->send();
    
    
        return response()->json(['message' => 'Đặt vé thành công']);
    }
}
