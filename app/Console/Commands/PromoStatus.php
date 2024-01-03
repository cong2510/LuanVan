<?php

namespace App\Console\Commands;

use App\Models\PromoCode;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PromoStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $promos = PromoCode::all();

        foreach ($promos as $promo) {
            if($promo->end_date < Carbon::now())
            {
                DB::table('promocode')->where('id',$promo->id)->update([
                    'promo_status' => PromoCode::PROMO_STATUS[1],
                ]);
            }else{
                DB::table('promocode')->where('id',$promo->id)->update([
                    'promo_status' => PromoCode::PROMO_STATUS[0],
                ]);
            }
        }

        $this->info('Product stock availability checked successfully.');
    }
}
