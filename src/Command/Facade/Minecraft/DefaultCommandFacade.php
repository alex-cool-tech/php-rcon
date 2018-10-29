<?php

namespace AlexCool\Rcon\Command\Facade\Minecraft;

use AlexCool\Rcon\Client\MinecraftClient;
use AlexCool\Rcon\Command\Facade\CommandFacadeInterface;
use AlexCool\Rcon\Utils\CommandFormatter;

/**
 * @package AlexCool\Rcon\Command\Minecraft
 */
class DefaultCommandFacade implements CommandFacadeInterface
{
    /**
     * @var MinecraftClient
     */
    private $client;

    /**
     * @var CommandFormatter
     */
    private $commandFormatter;

    /**
     * @param MinecraftClient $client
     * @param CommandFormatter $commandFormatter
     */
    public function __construct(MinecraftClient $client, CommandFormatter $commandFormatter)
    {
        $this->client = $client;
        $this->commandFormatter = $commandFormatter;
    }
}