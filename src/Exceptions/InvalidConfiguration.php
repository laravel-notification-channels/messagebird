<?php

namespace NotificationChannels\Messagebird\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via Messagebird you need to add credentials in the `messagebird` key of `config.services`.');
    }
}
