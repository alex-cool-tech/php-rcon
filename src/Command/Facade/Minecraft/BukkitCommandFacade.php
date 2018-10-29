<?php

namespace AlexCool\Rcon\Command\Facade\Minecraft;

use AlexCool\Rcon\Client\MinecraftClient;
use AlexCool\Rcon\Command\Facade\CommandFacadeInterface;
use AlexCool\Rcon\Utils\CommandFormatter;

/**
 * @package AlexCool\Rcon\Command\Minecraft
 */
class BukkitCommandFacade implements CommandFacadeInterface
{
    /**
     * Command list
     */
    const VERSION_COMMAND = 'version';
    const PLUGINS_COMMAND = 'plugins';
    const RELOAD_COMMAND = 'reload';
    const TIMINGS_COMMAND = 'timings';
    const HELP_COMMAND = 'help';

    const DEFAULT_HELP_PAGE = 1;

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

    /**
     * Gives the version number of CraftBukkit which is installed on the server.
     *
     * @return bool|mixed
     */
    public function version()
    {
        return $this->sendCommand(self::VERSION_COMMAND);
    }

    /**
     * Lists all installed plugins on the server.
     *
     * @return bool|mixed
     */
    public function plugins()
    {
        return $this->sendCommand(self::PLUGINS_COMMAND);
    }

    /**
     * Stops and restarts all plugins on the server.
     *
     * @return bool|mixed
     */
    public function reload()
    {
        return $this->sendCommand(self::RELOAD_COMMAND);
    }

    /**
     * Records timings for all plugin events.
     *
     * @param string $option
     *
     * @return bool|mixed
     */
    public function timings(string $option)
    {
        $this->commandFormatter
            ->addElement('%s', self::TIMINGS_COMMAND)
            ->addElement('%s', $option);

        return $this->sendCommand($this->commandFormatter->compile());
    }

    /**
     * Client command execute wrapper.
     *
     * @param string $command
     *
     * @return bool|mixed
     */
    private function sendCommand(string $command)
    {
        return $this->client->sendCommand($command);
    }
}