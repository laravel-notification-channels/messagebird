<?php

namespace NotificationChannels\Messagebird;

use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\Messagebird\Exceptions\InvalidConfiguration;

class MessagebirdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(MessagebirdChannel::class)
            ->needs(MessagebirdClient::class)
            ->give(function () {
                $config = config('services.messagebird');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new MessagebirdClient(new Client(), $config['access_key']);
            });

        $this->app[ChannelManager::class]->extend('messagebird', function ($app) {
            return $app->make(MessagebirdChannel::class);
        });
    }
}
