<?php

namespace NotificationChannels\Messagebird\Test;

use MessageBird\Client;
use Mockery;
use NotificationChannels\Messagebird\MessagebirdClient;
use PHPUnit_Framework_TestCase;

class MessagebirdClientTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->messagebirdClient = Mockery::mock(new Client('test_1234567890'));
        $this->client = Mockery::mock(new MessagebirdClient($this->messagebirdClient));
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
    }
}
