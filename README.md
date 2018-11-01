PHP Rcon
==================
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/build-status/master)

Project forked from [thedudeguy/PHP-Minecraft-Rcon](https://github.com/thedudeguy/PHP-Minecraft-Rcon)

## Installation
This Rcon library may be installed by issuing the following command:
```bash
$ composer require alex.cool/rcon
```

## Example
For this script to work, rcon must be enabled on the server, by setting `enable-rcon=true` in the server's `server.properties` file. A password must also be set, and provided in the script.

```php
require_once __DIR__ . '/vendor/autoload.php';

use AlexCool\Rcon\Client\MinecraftClient;
use AlexCool\Rcon\Command\Wrapper\Minecraft\BukkitCommandWrapper;
use AlexCool\Rcon\Utils\CommandFormatter;

$host = 'some.minecraftserver.com'; // Server host name or IP
$port = 25575; // Port rcon is listening on
$password = 'server-rcon-password'; // rcon.password setting set in server.properties
$timeout = 3; // How long to timeout.

$client = new Swoole\Client(SWOOLE_SOCK_TCP);

$client->set([
    'open_length_check' => true,
    'package_length_type' => 'V',
    'package_length_offset' => 0, // The offset of package length variable
    'package_body_offset' => 4, // The offset of body of the package
]);

$minecraftClient = new MinecraftClient($client, $host, $port, $password, $timeout);
$bukkitCommands = new BukkitCommandWrapper($minecraftClient, new CommandFormatter());

if ($minecraftClient->connect()) {
    echo $bukkitCommands->sendCommand('say Hello World!');
}
```
