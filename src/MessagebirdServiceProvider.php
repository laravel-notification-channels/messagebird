<?php

namespace NotificationChannels\Messagebird;

use Illuminate\Support\ServiceProvider;
use MessageBird\Client;
use NotificationChannels\Messagebird\Exceptions\InvalidConfiguration;

class MessagebirdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(MessagebirdChannel::class)
            ->needs(Client::class)
            ->give(function () {
                $config = config('services.messagebird');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new Client(
                    $config['access_key']
                );
            });
    }
}
