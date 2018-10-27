<?php

namespace App;

/**
 * See https://developer.valvesoftware.com/wiki/Source_RCON_Protocol for
 * more information about Source RCON Packets
 *
 * @author alex.cool
 * @link https://github.com/Chipka94/PHP-Minecraft-Rcon
 */

/**
 * @package App
 */
class Rcon
{
    const SERVER_DATA_AUTH = 3;
    const SERVER_DATA_AUTH_RESPONSE = 2;
    const SERVER_DATA_EXEC_COMMAND = 2;
    const SERVER_DATA_RESPONSE_VALUE = 0;

    const PACKET_AUTHORIZE = 5;
    const PACKET_COMMAND = 6;

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
     * @var int
     */
    private $timeout;

    /**
     * @var resource
     */
    private $socket;

    /**
     * @var bool
     */
    private $authorized = false;

    /**
     * @var string
     */
    private $lastResponse = '';

    /**
     * @param string $host
     * @param int $port
     * @param string $password
     * @param int $timeout
     */
    public function __construct(string $host, int $port, string $password, int $timeout)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->timeout = $timeout;
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
        $this->socket = fsockopen($this->host, $this->port, $errNo, $errStr, $this->timeout);

        if (!$this->socket) {
            $this->lastResponse = $errStr;
            return false;
        }

        //set timeout
        stream_set_timeout($this->socket, 3, 0);

        // check authorization
        return $this->authorize();
    }

    /**
     * Disconnect from server.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    /**
     * True if socket is connected and authorized.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->authorized;
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
        if (!$this->isConnected()) {
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
        /*
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

        // attach size to packet.
        $packet = pack('V', $packetSize) . $packet;

        // write packet.
        fwrite($this->socket, $packet, strlen($packet));
    }

    /**
     * Read a packet from the socket stream.
     *
     * @return array
     */
    private function readPacket()
    {
        //get packet size.
        $sizeData = fread($this->socket, 4);
        $sizePack = unpack('V1size', $sizeData);
        $size = $sizePack['size'];

        // if size is > 4096, the response will be in multiple packets.
        // this needs to be address. get more info about multi-packet responses
        // from the RCON protocol specification at
        // https://developer.valvesoftware.com/wiki/Source_RCON_Protocol
        // currently, this script does not support multi-packet responses.

        $packetData = fread($this->socket, $size);
        $packetPack = unpack('V1id/V1type/a*body', $packetData);

        return $packetPack;
    }
}
