<?php

namespace NotificationChannels\Messagebird;

use Exception;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
use NotificationChannels\Messagebird\Exceptions\CouldNotSendNotification;
use MessageBird\Client;

class MessagebirdClient
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($message)
    {
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
