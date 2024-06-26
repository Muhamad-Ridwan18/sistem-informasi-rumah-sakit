<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Queue;

class ClearQueueTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:reset';

    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset queue table daily';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Queue::truncate(); // Mengosongkan tabel antrian
        $this->info('Queue table has been reset.');
    }
}
