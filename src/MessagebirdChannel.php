<?php

namespace NotificationChannels\Messagebird;

use Exception;
use Illuminate\Notifications\Notification;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
use NotificationChannels\Messagebird\Exceptions\CouldNotSendNotification;
use NotificationChannels\Messagebird\Events\MessageWasSent;
use NotificationChannels\Messagebird\Events\SendingMessage;
use MessageBird\Client;

class MessagebirdChannel
{
    /** @var \MessageBird\Client */
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
        } catch (AuthenticateException $exception) {
            throw CouldNotSendNotification::couldNotAuthenticate();
        } catch (BalanceException $exception) {
            throw CouldNotSendNotification::notEnoughCredits();
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }

        event(new MessageWasSent($notifiable, $notification));
    }
}
