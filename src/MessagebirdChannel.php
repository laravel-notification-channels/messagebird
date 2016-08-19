<?php

namespace NotificationChannels\Messagebird;

use Illuminate\Notifications\Notification;

class MessagebirdChannel
{
    /** @var \MessageBird\Client */
    protected $client;

    public function __construct(MessagebirdClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\MessageBird\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMessagebird($notifiable);

        if (is_string($message)) {
            $message = MessagebirdMessage::create($message);
        }

        $this->client->send($message);
    }
}
