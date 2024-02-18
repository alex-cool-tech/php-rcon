<?php

namespace AlexCool\Rcon\Command\Wrapper\Minecraft;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Command\Wrapper\Minecraft
 */
final class BukkitCommandWrapper extends CoreCommandWrapper
{
    /**
     * Command list
     */
    const VERSION_COMMAND = 'version';
    const PLUGINS_COMMAND = 'plugins';
    const RELOAD_COMMAND = 'reload';
    const TIMINGS_COMMAND = 'timings';

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
}
