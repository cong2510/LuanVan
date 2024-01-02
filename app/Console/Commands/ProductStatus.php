<?php

namespace App\Console\Commands;

use App\Models\Sanpham;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProductStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product status on daily';

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
        $sanphams = Sanpham::all();

        foreach ($sanphams as $sanpham) {
            if($sanpham->soluong == 0)
            {
                DB::table('sanpham')->where('id',$sanpham->id)->update([
                    'tinhtrang' => 0
                ]);
            }else{
                DB::table('sanpham')->where('id',$sanpham->id)->update([
                    'tinhtrang' => 1
                ]);
            }
        }

        $this->info('Product stock availability checked successfully.');
    }
}
