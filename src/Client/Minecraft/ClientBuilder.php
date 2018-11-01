<?php

namespace AlexCool\Rcon\Client\Minecraft;

use Swoole\Client as SwooleClient;
use AlexCool\Rcon\Configurator\BuilderConfigurator;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Client
 */
final class ClientBuilder
{
    /**
     * Swoole client constants
     */
    const OPEN_LENGTH_CHECK = true;
    const PACKAGE_LENGTH_TYPE = 'V';
    const PACKAGE_LENGTH_OFFSET = 0; // The offset of package length variable
    const PACKAGE_BODY_OFFSET = 4; // The offset of body of the package

    /**
     * @var SwooleClient
     */
    private $swooleClient;

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
    public function createSwooleClient()
    {
        $this->swooleClient = new SwooleClient(SWOOLE_SOCK_TCP);
        $this->swooleClient->set([
            'open_length_check' => self::OPEN_LENGTH_CHECK,
            'package_length_type' => self::PACKAGE_LENGTH_TYPE,
            'package_length_offset' => self::PACKAGE_LENGTH_OFFSET,
            'package_body_offset' => self::PACKAGE_BODY_OFFSET,
        ]);

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return new Client(
            $this->swooleClient,
            $this->config->getHost(),
            $this->config->getRconPort(),
            $this->config->getRconPassword(),
            $this->config->getRconTimeout()
        );
    }
}
