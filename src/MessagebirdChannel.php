<?php

namespace NotificationChannels\Messagebird;

use Exception;
use Illuminate\Notifications\Notification;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
use NotificationChannels\Messagebird\Exceptions\CouldNotSendNotification;
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
        $message = $notification->toMessagebird($notifiable);

        if (is_string($message)) {
            $message = MessagebirdMessage::create($message);
        }

        if (empty($message->originator)) {
            $message->setOriginator(config('services.messagebird.originator'));
        }

        if (empty($message->recipients)) {
            $message->setRecipients(config('services.messagebird.recipients'));
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
    }
}
