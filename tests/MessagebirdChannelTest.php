<?php

namespace NotificationChannels\Messagebird\Test;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use MessageBird\Client;
use Mockery;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdClient;
use NotificationChannels\Messagebird\MessagebirdMessage;
use PHPUnit_Framework_TestCase;

class MessagebirdChannelTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->notification = new TestNotification;
        $this->notifiable = new TestNotifiable;
        $this->messagebirdClient = Mockery::mock(new Client('test_1234567890'));
        $this->client = Mockery::mock(new MessagebirdClient($this->messagebirdClient));
        $this->channel = new MessagebirdChannel($this->client);
    }

    public function tearDown()
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
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForMessagebird()
    {
        return '0031650520659';
    }
}

class TestNotification extends Notification
{
    public function toMessagebird($notifiable)
    {
        return (new MessagebirdMessage("Message content"))->setOriginator('APPNAME')->setRecipients('0031650520659');
    }
}
