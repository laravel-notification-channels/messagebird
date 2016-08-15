<?php

namespace NotificationChannels\Messagebird\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @param Exception $exception
     * @return static
     */
    public static function serviceRespondedWithAnError(Exception $exception)
    {
        return new static("MessageBird service responded with an error '{$exception->getCode()}: {$exception->getMessage()}'");
    }

    /**
     * @return static
     */
    public static function couldNotAuthenticate()
    {
        return new static('You have entered the wrong credentials.');
    }

    /**
     * @return static
     */
    public static function notEnoughCredits()
    {
        return new static('Not enough credits.');
    }
}
