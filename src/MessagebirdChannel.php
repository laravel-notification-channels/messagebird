<?php

namespace NotificationChannels\Messagebird;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use NotificationChannels\Messagebird\Exceptions\CouldNotSendNotification;

class MessagebirdChannel
{
    /** @var \NotificationChannels\Messagebird\MessagebirdClient */
    protected $client;
    private $_dispatcher;

    public function __construct(MessagebirdClient $client, Dispatcher $dispatcher = null)
    {
        $this->client = $client;
        $this->_dispatcher = $dispatcher;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return array
     * @throws \NotificationChannels\MessageBird\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMessagebird($notifiable);

        $response = [];

        if (is_string($message)) {
            $message = MessagebirdMessage::create($message);
        }

        if ($to = $notifiable->routeNotificationFor('messagebird')) {
            $message->setRecipients($to);
        }

        try {
            $response = $this->client->send($message);

            if($this->_dispatcher !== null){
                $this->_dispatcher->dispatch('messagebird-sms', [$notifiable, $notification, $response]);
            }
        } catch (CouldNotSendNotification $e) {
            new NotificationFailed(
                $notifiable,
                $notification,
                'messagebird-sms',
                $e->getMessage()
            );
        }

        return $response;
    }
}
