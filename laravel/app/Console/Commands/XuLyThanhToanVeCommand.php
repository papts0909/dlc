<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\AdminClient\AdminClient;
use Junges\Kafka\Config\Config;
use App\Models\Ve;
use Illuminate\Support\Facades\DB;
use App\Events\ThanhToanThanhCong;

class XuLyThanhToanVeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-thanh-toan-ve';

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
                
                DB::beginTransaction();
                try{  
                    if(count($body) > 0){
                        foreach ($body as $veId => $_message) {
                            // Cập nhật trạng thái vé
                            $ve = Ve::find($veId);
                            $ve->trang_thai_thanh_toan = 'DA_THANH_TOAN';
                            $ve->save();
                            
                            // Pub sự kiện "thanh toán vé thành công"
                            Kafka::publish()
                                ->onTopic('thanh_toan_ve_thanh_cong')
                                ->withBodyKey($veId,json_encode([]))
                                ->send();
                            
                            // Trigger event broadcast
                            event(new ThanhToanThanhCong('Thanh toán thành công cho vé #' . $veId)); 
                        }
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    // Log::error($e->getMessage());
                }

            })
            ->withAutoCommit()
            ->withMaxMessages(1)
            ->build();

        $consumer->consume();
    }
}
