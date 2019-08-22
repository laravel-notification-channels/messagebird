<?php

namespace NotificationChannels\Messagebird\Test;

use Mockery;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Messagebird\MessagebirdClient;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;

class MessagebirdChannelTest extends TestCase
{
    public function setUp(): void
    {
        $this->notification = new TestNotification;
        $this->string_notification = new TestStringNotification;
        $this->notifiable = new TestNotifiable;
        $this->guzzle = Mockery::mock(new Client());
        $this->client = Mockery::mock(new MessagebirdClient($this->guzzle, 'test_ek1qBbKbHoA20gZHM40RBjxzX'));
        $this->channel = new MessagebirdChannel($this->client);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(MessagebirdClient::class, $this->client);
        $this->assertInstanceOf(MessagebirdChannel::class, $this->channel);
    }

    /** @test */
    public function test_it_shares_message()
    {
        $this->client->shouldReceive('send')->once();
        $this->assertNull($this->channel->send($this->notifiable, $this->notification));
    }

    /** @test */
    public function if_string_message_can_be_send()
    {
        $this->client->shouldReceive('send')->once();
        $this->assertNull($this->channel->send($this->notifiable, $this->string_notification));
    }
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForMessagebird()
    {
        return '31650520659';
    }
}

class TestNotification extends Notification
{
    public function toMessagebird($notifiable)
    {
        return (new MessagebirdMessage('Message content'))->setOriginator('APPNAME')->setRecipients('31650520659');
    }
}

class TestStringNotification extends Notification
{
    public function toMessagebird($notifiable)
    {
        return 'Test by string';
    }
}
