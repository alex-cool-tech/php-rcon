PHP-Rcon
==================
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alexcool94/PHP-Rcon/build-status/master)

Simple Rcon class for php.

Project forked from [thedudeguy/PHP-Minecraft-Rcon](https://github.com/thedudeguy/PHP-Minecraft-Rcon)

## Installation
### Using Composer
This Rcon library may be installed by issuing the following command:
```bash
$ composer require alex.cool/rcon
```

## Example
For this script to work, rcon must be enabled on the server, by setting `enable-rcon=true` in the server's `server.properties` file. A password must also be set, and provided in the script.

```php
$host = 'some.minecraftserver.com'; // Server host name or IP
$port = 25575; // Port rcon is listening on
$password = 'server-rcon-password'; // rcon.password setting set in server.properties
$timeout = 3; // How long to timeout.

use App\Rcon;

$rcon = new Rcon($host, $port, $password, $timeout);

if ($rcon->connect()) {
  $rcon->sendCommand("say Hello World!");
}
```
