<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class APICron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'API:cron';

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
        //
        \Log::info("Cron is working fine!");
    }
}
