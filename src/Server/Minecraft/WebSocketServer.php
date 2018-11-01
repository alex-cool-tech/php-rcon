<?php

namespace AlexCool\Rcon\Server\Minecraft;

use AlexCool\Rcon\Server\AbstractServer;
use Swoole\WebSocket\Server;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Server\Minecraft
 */
final class WebSocketServer extends AbstractServer
{
    /**
     * Events
     */
    const OPEN_EVENT = 'open';
    const HANDSHAKE_EVENT = 'handshake';

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @param WebSocketServerBuilder $builder
     *
     * @return WebSocketServer
     */
    public static function build(WebSocketServerBuilder $builder)
    {
        return $builder
            ->createWebSocketServer()
            ->getServer();
    }

    /**
     * @param callable $callback
     */
    public function onOpen(callable $callback)
    {
        $this->server->on(self::OPEN_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onHandshake(callable $callback)
    {
        $this->server->on(self::HANDSHAKE_EVENT, $callback);
    }
}
