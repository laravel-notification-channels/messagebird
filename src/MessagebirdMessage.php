<?php

namespace NotificationChannels\Messagebird;

use MessageBird\Objects\Message;

class MessagebirdMessage extends Message
{

    public static function create($body = '', $originator = null, $recipients = null)
    {
        return new static($body, $originator, $recipients);
    }

    public function __construct($body = '', $originator = null, $recipients = null)
    {
        if (!empty($body)) {
            $this->body(trim($body));
        }

        $this->setOriginator($originator);
        $this->setRecipients($recipients);
    }

    public function setOriginator($originator)
    {
        $this->originator = $originator ?: config('services.messagebird.originator');
    }

    public function setRecipients($recipients = null)
    {
        if (!$recipients) {
            $recipients = config('services.messagebird.recipients');
        }

        if (is_string($recipients)) {
            $recipients = [$recipients];
        }

        $this->recipients = $recipients;

        return $this;

    }
}