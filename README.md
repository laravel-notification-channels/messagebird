# Messagebird notifications channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/messagebird.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/messagebird)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/messagebird/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/messagebird)
[![StyleCI](https://styleci.io/repos/65683649/shield)](https://styleci.io/repos/65683649)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/357bb8d3-2163-45be-97f2-ce71434a4379.svg?style=flat-square)](https://insight.sensiolabs.com/projects/357bb8d3-2163-45be-97f2-ce71434a4379)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/messagebird.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/messagebird)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/messagebird/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/messagebird/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/messagebird.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/messagebird)

This package makes it easy to send [Messagebird SMS notifications](https://github.com/messagebird/php-rest-api) with Laravel.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Setting up your Messagebird account](#setting-up-your-messagebird-account)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Requirements

- [Sign up](https://www.messagebird.com/en/signup) for a free MessageBird account
- Create a new access_key in the developers sections

## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/messagebird
```

for Laravel 5.4 or lower, you must add the service provider to your config:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Messagebird\MessagebirdServiceProvider::class,
],
```

## Setting up your Messagebird account

Add the environment variables to your `config/services.php`:

```php
// config/services.php
...
'messagebird' => [
    'access_key' => env('MESSAGEBIRD_ACCESS_KEY'),
    'originator' => env('MESSAGEBIRD_ORIGINATOR'),
    'recipients' => env('MESSAGEBIRD_RECIPIENTS'),
],
...
```

Add your Messagebird Access Key, Default originator (name or number of sender), and default recipients to your `.env`:

```php
// .env
...
MESSAGEBIRD_ACCESS_KEY=
MESSAGEBIRD_ORIGINATOR=
MESSAGEBIRD_RECIPIENTS=
],
...
```

Notice: The originator can contain a maximum of 11 alfa-numeric characters.

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;
use Illuminate\Notifications\Notification;

class VpsServerOrdered extends Notification
{
    public function via($notifiable)
    {
        return [MessagebirdChannel::class];
    }

    public function toMessagebird($notifiable)
    {
        return (new MessagebirdMessage("Your {$notifiable->service} was ordered!"));
    }
}
```

Additionally you can add recipients (single value or array)

``` php
return (new MessagebirdMessage("Your {$notifiable->service} was ordered!"))->setRecipients($recipients);
```

In order to handle a status report you can also set a reference

``` php
return (new MessagebirdMessage("Your {$notifiable->service} was ordered!"))->setReference($id);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email psteenbergen@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Peter Steenbergen](http://petericebear.github.io)
- [Tonko Mulder](https://tonkomulder.nl)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
