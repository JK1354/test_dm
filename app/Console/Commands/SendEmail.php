<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DMController;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:mail';

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
     *
     * @return int
     */
    public function handle()
    {
        // $mail= new DMController;
        // $mail->handle();
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch(new \App\Jobs\MailJob());
    }
}
