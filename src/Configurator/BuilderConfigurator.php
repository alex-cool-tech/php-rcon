<?php

namespace AlexCool\Rcon\Configurator;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Server\Minecraft
 */
final class BuilderConfigurator
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $serverPort;

    /**
     * @var int
     */
    private $rconPort;

    /**
     * @var string
     */
    private $rconPassword;

    /**
     * @var float
     */
    private $rconTimeout;

    /**
     * @param string $host
     * @param int $serverPort
     * @param int $rconPort
     * @param string $rconPassword
     * @param float $rconTimeout
     *
     * @return BuilderConfigurator
     */
    public static function setup(
        string $host,
        int $serverPort,
        int $rconPort,
        string $rconPassword,
        float $rconTimeout
    ) {
        $self = new static();

        $self->host = $host;
        $self->serverPort = $serverPort;
        $self->rconPort = $rconPort;
        $self->rconPassword = $rconPassword;
        $self->rconTimeout = $rconTimeout;

        return $self;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getServerPort(): int
    {
        return $this->serverPort;
    }

    /**
     * @return int
     */
    public function getRconPort(): int
    {
        return $this->rconPort;
    }

    /**
     * @return string
     */
    public function getRconPassword(): string
    {
        return $this->rconPassword;
    }

    /**
     * @return float
     */
    public function getRconTimeout(): float
    {
        return $this->rconTimeout;
    }
}
