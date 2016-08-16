<?php

namespace NotificationChannels\Messagebird;

use MessageBird\Objects\Message;

class MessagebirdMessage extends Message
{
    public static function create($body = '')
    {
        return new static($body);
    }

    public function __construct($body = '')
    {
        if (! empty($body)) {
            $this->body = trim($body);
        }
    }

    public function setBody($body)
    {
        $this->body = trim($body);

        return $this;
    }

    public function setOriginator($originator)
    {
        $this->originator = $originator;

        return $this;
    }

    public function setRecipients($recipients)
    {
        if (is_string($recipients)) {
            $recipients = [$recipients];
        }

        $this->recipients = $recipients;

        return $this;
    }
}
