<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Provider;
use App\Service\ProviderX;
use App\Service\ProviderY;

class ProviderImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Users from provider Json file';

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
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->choice('Select Provider?', ['X', 'Y'], 0);

        $provider = ($name == "X") ? 
                   resolve(ProviderX::class) :
                   resolve(ProviderY::class);;

        $provider->saveImport();

        $this->info("Provider$name Imported");

        
    }
}
