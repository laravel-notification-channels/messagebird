<?php

namespace NotificationChannels\Messagebird\Test;

use NotificationChannels\Messagebird\MessagebirdMessage;

class MessagebirdMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $message = new MessagebirdMessage;
        $this->assertInstanceOf(MessagebirdMessage::class, $message);
    }

    /** @test */
    public function it_can_accept_body_content_when_created()
    {
        $message = new MessagebirdMessage('Foo');
        $this->assertEquals('Foo', $message->body);
    }

    /** @test */
    public function it_supports_create_method()
    {
        $message = MessagebirdMessage::create('Foo');
        $this->assertInstanceOf(MessagebirdMessage::class, $message);
        $this->assertEquals('Foo', $message->body);
    }

    /** @test */
    public function it_can_set_body()
    {
        $message = (new MessagebirdMessage)->setBody('Bar');
        $this->assertEquals('Bar', $message->body);
    }

    /** @test */
    public function it_can_set_originator()
    {
        $message = (new MessagebirdMessage)->setOriginator('APPNAME');
        $this->assertEquals('APPNAME', $message->originator);
    }

    /** @test */
    public function it_can_set_recipients_from_array()
    {
        $message = (new MessagebirdMessage)->setRecipients([31650520659]);
        $this->assertEquals([31650520659], $message->recipients);
    }

    /** @test */
    public function it_can_set_recipients_from_string()
    {
        $message = (new MessagebirdMessage)->setRecipients('31650520659');
        $this->assertEquals([31650520659], $message->recipients);
    }
}
