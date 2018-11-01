<?php

namespace AlexCool\Rcon\Client;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Client
 */
interface ClientInterface
{
    public function connect();
    public function disconnect();
    public function sendCommand(string $command);
}
