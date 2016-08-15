<?php

namespace NotificationChannels\Messagebird;

use Illuminate\Notifications\Notification;
use NotificationChannels\Messagebird\Exceptions\CouldNotSendNotification;
use NotificationChannels\Messagebird\Events\MessageWasSent;
use NotificationChannels\Messagebird\Events\SendingMessage;
use MessageBird\Client;

class MessagebirdChannel
{
    protected $client;

    public function __construct(Client $client)
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
        $shouldSendMessage = event(new SendingMessage($notifiable, $notification), [], true) !== false;
        if (! $shouldSendMessage) {
            return;
        }

        $message = $notification->toMessagebird($notifiable);

        if (is_string($message)) {
            $message = MessagebirdMessage::create($message);
        }

        try {
            $this->client->messages->create($message);
        } catch (\MessageBird\Exceptions\AuthenticateException $e) {
            throw CouldNotSendNotification::balanceException();
        } catch (\MessageBird\Exceptions\BalanceException $e) {
            throw CouldNotSendNotification::balanceException();
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }

        event(new MessageWasSent($notifiable, $notification));
    }
}
