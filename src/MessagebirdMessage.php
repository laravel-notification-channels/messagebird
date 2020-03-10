<?php

namespace NotificationChannels\Messagebird;

class MessagebirdMessage
{
    public $body;
    public $originator;
    public $recipients;
    public $reference;
    public $reportUrl;

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
        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        $this->recipients = $recipients;

        return $this;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function setDatacoding($datacoding)
    {
        $this->datacoding = $datacoding;

        return $this;
    }

    public function setReportUrl($reportUrl)
    {
        $this->reportUrl = $reportUrl;

        return $this;
    }

    public function toJson()
    {
        return json_encode($this);
    }
}
