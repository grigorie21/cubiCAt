<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Throwable;

class RedisSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:sub';

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
    public function handle(): int
    {
        ini_set("default_socket_timeout", -1);

        try {
            Redis::subscribe(['events'], function ($message) {
                dump($message);
            });
        } catch (Throwable $e) {
            dump($e->getMessage());
        }

        return 0;
    }
}
