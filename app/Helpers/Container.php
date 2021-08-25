<?php

namespace App\Helpers;


class Container
{
    public static function all(): array {
        $socket = stream_socket_client("unix:///var/run/docker.sock", $error_code, $error_message, 30);
        $containers = [];

        fwrite($socket, "GET http://localhost/containers/json?all=1&size=1 HTTP/1.0\r\nHost: localhost\r\nAccept: */*\r\n\r\n");

        while(!feof($socket)) {
            $containersJson = fgets($socket, pow(1024, 2));

            foreach (json_decode($containersJson) ?? [] as $container)
            {
                $containers[$container->Id] = $container;
            }
        }

        fclose($socket);

        return $containers;
    }

    public static function get(string $id): ?object
    {
        $socket = stream_socket_client("unix:///var/run/docker.sock", $error_code, $error_message, 30);

        fwrite($socket, "GET http://localhost/containers/{$id}/json HTTP/1.0\r\nHost: localhost\r\nAccept: */*\r\n\r\n");

        while(!feof($socket)) {
            $containerJson = fgets($socket, pow(1024, 2));
            $container = json_decode($containerJson);
        }

        fclose($socket);

        return $container ?? null;
    }
}
