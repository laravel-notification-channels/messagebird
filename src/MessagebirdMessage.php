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

    private function setOriginator($originator)
    {
        $this->originator = $originator ?: config('services.messagebird.originator');
    }

    private function setRecipients($recipients)
    {
        if (is_array($recipients)) {
            $this->recipients = $recipients;
        } elseif (is_string($recipients)) {
            $this->recipients[] = $recipients;
        } else {
            $this->recipients[] = config('services.messagebird.recipients');
        }
    }
}