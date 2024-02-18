<?php

namespace AlexCool\Rcon\Server;

use Swoole\Server;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Server
 */
abstract class AbstractServer
{
    /**
     * Events
     */
    const CLOSE_EVENT = 'close';
    const MESSAGE_EVENT = 'message';
    const START_EVENT = 'start';
    const SHUTDOWN_EVENT = 'shutdown';
    const WORKER_START_EVENT = 'WorkerStart';
    const WORKER_STOP_EVENT = 'WorkerStop';
    const WORKER_ERROR_EVENT = 'WorkerError';
    const TIMER_EVENT = 'timer';
    const CONNECT_EVENT = 'connect';
    const RECEIVE_EVENT = 'receive';
    const TASK_EVENT = 'task';
    const FINISH_EVENT = 'finish';
    const PIPE_MESSAGE_EVENT = 'PipeMessage';
    const MANAGER_START_EVENT = 'ManagerStart';
    const MANAGER_STOP_EVENT = 'ManagerStop';

    /**
     * @var Server
     */
    protected $server;

    /**
     * @return void
     */
    public function run()
    {
        $this->server->start();
    }

    /**
     * @param callable $callback
     */
    public function onStart(callable $callback)
    {
        $this->server->on(self::START_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onClose(callable $callback)
    {
        $this->server->on(self::CLOSE_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onShutdown(callable $callback)
    {
        $this->server->on(self::SHUTDOWN_EVENT, $callback);
    }
    /**
     * @param callable $callback
     */
    public function onWorkerStart(callable $callback)
    {
        $this->server->on(self::WORKER_START_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onWorkerStop(callable $callback)
    {
        $this->server->on(self::WORKER_STOP_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onWorkerError(callable $callback)
    {
        $this->server->on(self::WORKER_ERROR_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onMessage(callable $callback)
    {
        $this->server->on(self::MESSAGE_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onTimer(callable $callback)
    {
        $this->server->on(self::TIMER_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onConnect(callable $callback)
    {
        $this->server->on(self::CONNECT_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onReceive(callable $callback)
    {
        $this->server->on(self::RECEIVE_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onTask(callable $callback)
    {
        $this->server->on(self::TASK_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onFinish(callable $callback)
    {
        $this->server->on(self::FINISH_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onPipeMessage(callable $callback)
    {
        $this->server->on(self::PIPE_MESSAGE_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onManagerStart(callable $callback)
    {
        $this->server->on(self::MANAGER_START_EVENT, $callback);
    }

    /**
     * @param callable $callback
     */
    public function onManagerStop(callable $callback)
    {
        $this->server->on(self::MANAGER_STOP_EVENT, $callback);
    }
}
