<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Junges\Kafka\Facades\Kafka;
// use App\Mail\XacNhanDatVe; 
use Illuminate\Support\Facades\Mail;
use App\Models\Ve;
use Illuminate\Support\Facades\DB;

class GuiMailChoKhachHangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume-gui-mail';

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
        $consumer = Kafka::consumer(['thanh_toan_ve_thanh_cong'])
        ->withHandler(function ($message) {
            $body = $message->getBody(); // Lấy body
            
            DB::beginTransaction();
            try{
                if(count($body) > 0){
                    foreach ($body as $veId => $_message) {
                        $ve = Ve::find($veId);
                        $ve->trang_thai_gui_mail = 'DA_GUI';
                        $ve->save();
            
                        // Gửi mail xác nhận
                        // Mail::to($ve->email)->send(new XacNhanDatVe($ve)); 
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // Log::error($e->getMessage());
            }
        })
        ->withAutoCommit()
        // ->withMaxMessages(1)
        ->build();

        $consumer->consume();
    }
}
