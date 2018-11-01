<?php

namespace AlexCool\Rcon\Utils;

/**
 * @author Aleksandr Kulina <chipka94@gmail.com>
 *
 * @package AlexCool\Rcon\Utils
 */
final class CommandFormatter
{
    /**
     * @var array
     */
    private $format;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return implode(' ', $this->format);
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param string $format
     * @param $argument
     *
     * @return $this
     */
    public function addElement(string $format, $argument)
    {
        $this->format[] .= $format;
        $this->arguments[] .= $argument;

        return $this;
    }

    /**
     * Return result string
     *
     * @return string
     */
    public function compile()
    {
        return vsprintf(implode(' ', $this->format), $this->arguments);
    }
}
