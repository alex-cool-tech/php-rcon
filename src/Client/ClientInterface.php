<?php

namespace BrettHaddoak\Rcon\Client;

/**
 * @package BrettHaddoak\Rcon\Client
 */
interface ClientInterface
{
    public function connect();
    public function disconnect();
    public function sendCommand(string $command);
}