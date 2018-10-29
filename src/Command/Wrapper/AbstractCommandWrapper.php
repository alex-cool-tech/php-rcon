<?php

namespace AlexCool\Rcon\Command\Wrapper;

use AlexCool\Rcon\Client\ClientInterface;
use AlexCool\Rcon\Utils\CommandFormatter;

/**
 * @package AlexCool\Rcon\Command\Wrapper
 */
abstract class AbstractCommandWrapper
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var CommandFormatter
     */
    protected $commandFormatter;

    /**
     * Send raw command
     *
     * @param string $command
     *
     * @return bool|mixed
     */
    final public function sendCommand(string $command)
    {
        return $this->client->sendCommand($command);
    }
}
