<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Workerman\Worker;
use Workerman\Redis\Client;

class ws extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:st {s}';

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
        $argv[1] = 'start';
        $_SERVER['argv'][1] = 'start';

// Create a Websocket server
        $ws_worker = new Worker('websocket://0.0.0.0:3000');

// 4 processes
        $ws_worker->count = 1;

        $connections = [];
// Emitted when new connection come
        $ws_worker->onConnect = function ($connection) use (&$connections) {
            echo "New connection\n";
            $connections[] = $connection;
        };

// Emitted when data received
        $ws_worker->onMessage = function ($connection, $data) {
            // Send hello $data
            $connection->send('Hello ' . $data);
        };

// Emitted when connection closed
        $ws_worker->onClose = function ($connection) {
            echo "Connection closed\n";
        };


        $ws_worker->onWorkerStart = function () use ($connections){
            echo 555;
            global $redis;
            $redis = new Client('redis://127.0.0.1:6379');
            $redis->subscribe(['d1'], function ($channel, $message) use ($connections){
                echo "$channel, $message"; // news, news content
                foreach ($connections as $v) {
                    $v->send($message);
                }
            });
        };


// Run worker
        Worker::runAll();
    }
}
