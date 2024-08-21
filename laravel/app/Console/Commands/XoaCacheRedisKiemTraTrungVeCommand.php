<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Junges\Kafka\Facades\Kafka;
use Illuminate\Support\Facades\Redis;
use App\Models\Ve;

class XoaCacheRedisKiemTraTrungVeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-xoa-cache-redis-kiem-tra-trung-ve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $consumer = Kafka::consumer(['dat_ve_thanh_cong'])
            ->withHandler(function ($message) {
                $body = $message->getBody(); // Lấy body
                
                if(count($body) > 0){
                    foreach ($body as $veId => $_message) {
                        // Cập nhật trạng thái vé
                        $ve = Ve::find($veId);
            
                        $key = $ve->ma_ghe . ':' . $ve->ma_chuyen . ':' . $ve->so_dien_thoai;
                        Redis::del($key); // Xóa cache Redis
                    }
                }
    
            })
            ->withAutoCommit()
            // ->withMaxMessages(1)
            ->build();

        $consumer->consume();
    }
}
