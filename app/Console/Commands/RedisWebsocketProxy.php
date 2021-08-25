<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Redis\Client;
use Workerman\Worker;

class RedisWebsocketProxy extends Command
{
    protected $signature = 'redis:proxy';
    protected $description = 'Command description';
    protected array $wsClients = [];
    protected object $redis;

    public function __construct()
    {
        parent::__construct();

        global $argv;
        $argv[1] = 'start';
    }

    function handle(): void
    {
        $wsWorker = new Worker('websocket://0.0.0.0:6380');
        $wsWorker->count = 1;

        $wsWorker->onWorkerStart = function () {
            $this->redis = new Client('redis://127.0.0.1:6379');

            $this->redis->subscribe(['channel-1'], function ($channel, $message) {
                foreach ($this->wsClients as $wsClient) {
                    $wsClient->send($message);
                }
            });
        };

        $wsWorker->onConnect = function ($connection) {
            $this->wsClients[$connection->id] = $connection;
        };

        $wsWorker->onMessage = function ($connection, $data) {

        };

        $wsWorker->onClose = function ($connection) {
            unset($this->wsClients[$connection->id]);
        };

        $wsWorker->onError = function ($connection, $code, $msg) {
            unset($this->wsClients[$connection->id]);
        };

        Worker::runAll();
    }
}
