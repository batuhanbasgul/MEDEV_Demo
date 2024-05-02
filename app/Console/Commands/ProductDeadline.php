<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProductDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:product_deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is any deprecated product.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("ProductDeadline");
        //return Command::SUCCESS;
        //Ürünü de pasif hale getirmeyi unutma
    }
}
