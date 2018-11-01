<?php

namespace AlexCool\Rcon\Server\Minecraft;

use AlexCool\Rcon\Configurator\BuilderConfigurator;
use Swoole\WebSocket\Server;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Server\Minecraft
 */
final class WebSocketServerBuilder
{
    /**
     * @var Server
     */
    private $webSocketServer;

    /**
     * @var BuilderConfigurator
     */
    private $config;

    /**
     * @param BuilderConfigurator $config
     */
    public function __construct(BuilderConfigurator $config)
    {
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function createWebSocketServer()
    {
        $this->webSocketServer = new Server($this->config->getHost(), $this->config->getServerPort());

        return $this;
    }

    /**
     * @return WebSocketServer
     */
    public function getServer()
    {
        return new WebSocketServer($this->webSocketServer);
    }
}
