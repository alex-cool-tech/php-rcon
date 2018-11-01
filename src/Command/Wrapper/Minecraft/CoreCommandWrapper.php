<?php

namespace AlexCool\Rcon\Command\Wrapper\Minecraft;

use AlexCool\Rcon\Client\Minecraft\Client as MinecraftClient;
use AlexCool\Rcon\Command\Wrapper\AbstractCommandWrapper;
use AlexCool\Rcon\Utils\CommandFormatter;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Command\Wrapper\Minecraft
 */
class CoreCommandWrapper extends AbstractCommandWrapper
{
    /**
     * Command list
     */
    const HELP_COMMAND = 'help';

    /**
     * @param MinecraftClient $client
     * @param CommandFormatter $commandFormatter
     */
    public function __construct(MinecraftClient $client, CommandFormatter $commandFormatter)
    {
        $this->client = $client;
        $this->commandFormatter = $commandFormatter;
    }

    /**
     * Shows a list of server or plugin commands in the console or in-game.
     *
     * @param string|null $topic
     * @param int|null $pageNumber
     *
     * @return bool|mixed
     */
    public function help(string $topic = null, int $pageNumber = null)
    {
        $this->commandFormatter->addElement('%s', self::HELP_COMMAND);

        if ($topic) {
            $this->commandFormatter->addElement('%s', $topic);
        }

        if ($pageNumber) {
            $this->commandFormatter->addElement('%u', $pageNumber);
        }

        return $this->sendCommand($this->commandFormatter->compile());
    }
}
