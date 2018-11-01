<?php

namespace AlexCool\Rcon\Client\Minecraft;

use Swoole\Client as SwooleClient;
use AlexCool\Rcon\Client\ClientInterface;

/**
 * See https://developer.valvesoftware.com/wiki/Source_RCON_Protocol for
 * more information about Source RCON Packets
 *
 * @author Chris Churchwell <chris@chrischurchwell.com>
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Client
 */
final class Client implements ClientInterface
{
    const SERVER_DATA_AUTH = 3;
    const SERVER_DATA_AUTH_RESPONSE = 2;
    const SERVER_DATA_EXEC_COMMAND = 2;
    const SERVER_DATA_RESPONSE_VALUE = 0;

    const PACKET_AUTHORIZE = 5;
    const PACKET_COMMAND = 6;

    /**
     * @var SwooleClient
     */
    private $client;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $password;

    /**
     * @var float
     */
    private $timeout;

    /**
     * @var bool
     */
    private $authorized = false;

    /**
     * @var string
     */
    private $lastResponse = '';

    /**
     * @param SwooleClient $client
     * @param string $host
     * @param int $port
     * @param string $password
     * @param float $timeout
     */
    public function __construct(SwooleClient $client, string $host, int $port, string $password, float $timeout)
    {
        $this->client = $client;
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->timeout = $timeout;
    }

    /**
     * @param ClientBuilder $builder
     *
     * @return Client
     */
    public static function build(ClientBuilder $builder)
    {
        return $builder
            ->createSwooleClient()
            ->getClient();
    }

    /**
     * Get the latest response from the server.
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Connect to a server.
     *
     * @return boolean
     */
    public function connect()
    {
        if (!$this->client->isConnected()) {
            $this->client->connect($this->host, $this->port, $this->timeout);
        }

        if (!$this->isAuthorized()) {
            // check authorization
            return $this->authorize();
        }

        return true;
    }

    /**
     * Disconnect from server.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->client->isConnected()) {
            $this->client->close();
        }
    }

    /**
     * Send a command to the connected server.
     *
     * @param string $command
     *
     * @return boolean|mixed
     */
    public function sendCommand(string $command)
    {
        if (!$this->isAuthorized()) {
            return false;
        }

        // send command packet
        $this->writePacket(self::PACKET_COMMAND, self::SERVER_DATA_EXEC_COMMAND, $command);

        // get response
        $responsePacket = $this->readPacket();
        if ($responsePacket['id'] == self::PACKET_COMMAND) {
            if ($responsePacket['type'] == self::SERVER_DATA_RESPONSE_VALUE) {
                $this->lastResponse = $responsePacket['body'];

                return $responsePacket['body'];
            }
        }

        return false;
    }

    /**
     * True if socket is authorized.
     *
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

    /**
     * Log into the server with the given credentials.
     *
     * @return boolean
     */
    private function authorize()
    {
        $this->writePacket(self::PACKET_AUTHORIZE, self::SERVER_DATA_AUTH, $this->password);
        $responsePacket = $this->readPacket();

        if ($responsePacket['type'] == self::SERVER_DATA_AUTH_RESPONSE) {
            if ($responsePacket['id'] == self::PACKET_AUTHORIZE) {
                $this->authorized = true;

                return true;
            }
        }

        $this->disconnect();
        return false;
    }

    /**
     * Writes a packet to the socket stream.
     *
     * @param $id
     * @param $type
     * @param string $body
     *
     * @return void
     */
    private function writePacket(int $id, int $type, $body = '')
    {
        /**
         * Size -> 32-bit little-endian Signed Integer Varies, see below.
         * ID -> 32-bit little-endian Signed Integer Varies, see below.
         * Type -> 32-bit little-endian Signed Integer Varies, see below.
         * Body -> Null-terminated ASCII String Varies, see below.
         * Empty String -> Null-terminated ASCII String 0x00
         */

        //create packet
        $packet = pack('VV', $id, $type); // ID, type
        $packet .= $body . "\x00\x00"; // body, 2 null bytes

        // get packet size.
        $packetSize = strlen($packet);

        // send prepared packet
        $this->client->send(pack('V', $packetSize) . $packet);
    }

    /**
     * Read a packet from the socket stream.
     *
     * @return array
     */
    private function readPacket()
    {
        /**
         * If size is > 4096, the response will be in multiple packets. This needs to be address.
         * Get more info about multi-packet responses from the RCON protocol specification at
         * https://developer.valvesoftware.com/wiki/Source_RCON_Protocol
         *
         * Currently, this script does not support multi-packet responses.
         */
        return unpack('V1size/V1id/V1type/a*body', $this->client->recv());
    }
}
