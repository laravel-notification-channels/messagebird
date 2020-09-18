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
    private $dispatcher;

    public function __construct(MessagebirdClient $client, Dispatcher $dispatcher = null)
    {
        $this->client = $client;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return object with response body data if succesful response from API | empty array if not
     * @throws \NotificationChannels\MessageBird\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMessagebird($notifiable);

        $data = [];

        if (is_string($message)) {
            $message = MessagebirdMessage::create($message);
        }

        if ($to = $notifiable->routeNotificationFor('messagebird')) {
            $message->setRecipients($to);
        }

        try {
            $data = $this->client->send($message);

            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch('messagebird-sms', [$notifiable, $notification, $data]);
            }
        } catch (CouldNotSendNotification $e) {
            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch(
                    new NotificationFailed(
                        $notifiable,
                        $notification,
                        'messagebird-sms',
                        $e->getMessage()
                    )
                );
            }
        }

        return $data;
    }
}
