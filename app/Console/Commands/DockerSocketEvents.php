<?php

namespace App\Console\Commands;

use App\Helpers\Container;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Throwable;

class DockerSocketEvents extends Command
{
    protected array $containers = [];
    protected $signature = 'docker:events';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->containers = Container::all();
        $this->updateContainers();

        $socket = stream_socket_client("unix:///var/run/docker.sock", $error_code, $error_message, 30);

        if (!$socket) {
            dd($error_code, $error_message);
        }


        fwrite($socket, "GET /events HTTP/1.0\r\nHost: localhost\r\nAccept: */*\r\n\r\n");

        while (!feof($socket)) {
            $dataJson = fgets($socket, pow(1024, 2));
            $event = json_decode($dataJson);

            if (!$event) {
                continue;
            }

            switch ($event->Type ?? null) {
                case 'container':
                    $containerId = $event->id;
                    $container = Container::get($containerId);
                    $this->containers[$containerId] = $container;

                    $this->updateContainers();

                    Redis::publish('events', json_encode([
                        'type' => 'event',
                        'context' => 'container_update',
                        'data' => $container,
                    ], JSON_UNESCAPED_UNICODE));
                    break;

                case 'network':
                    Redis::publish('events', json_encode([
                        'type' => 'event',
                        'context' => 'network',
                        'data' => $event,
                    ], JSON_UNESCAPED_UNICODE));
                    break;

                case 'volume':
                    Redis::publish('events', json_encode([
                        'type' => 'event',
                        'context' => 'volume',
                        'data' => $event,
                    ], JSON_UNESCAPED_UNICODE));
                    break;

                default:
                    dump($event->Type);
                    break;
            }
        }

        fclose($socket);

        return 0;
    }

    protected function updateContainers(): void
    {
        Redis::set('containers', json_encode($this->containers, JSON_UNESCAPED_UNICODE));
    }
}
