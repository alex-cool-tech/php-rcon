<?php

namespace AlexCool\Rcon\Client;

/**
 * @package AlexCool\Rcon\Client
 */
interface ClientInterface
{
    public function connect();
    public function disconnect();
    public function sendCommand(string $command);
}