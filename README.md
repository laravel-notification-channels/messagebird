# Messagebird notifications channel for Laravel 5.3

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send [Messagebird SMS notifications](https://github.com/messagebird/php-rest-api) with Laravel 5.3.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
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

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Messagebird\MessagebirdServiceProvider::class,
],
```

### Setting up your Jusibe account

Add your Jusibe Account Key, Acess Token, and From Number (optional) to your `config/services.php`:

```php
// config/services.php
...
'messagebird' => [
    'access_key' => env('MESSAGEBIRD_ACCESS_KEY'),
    'originator' => env('MESSAGEBIRD_ORIGINATOR'),
    'recipients' => env('MESSAGEBIRD_RECIPIENTS'),
]
...
```

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
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.