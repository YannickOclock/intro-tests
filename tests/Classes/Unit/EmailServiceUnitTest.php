<?php

namespace Tests\Classes\Unit;

use App\Classes\EmailService as Email;
use Exception;
use PHPUnit\Framework\TestCase;

class EmailServiceUnitTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(Email::class, Email::fromString('user@example.com'));
    }
    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(Exception::class);
        Email::fromString('john');
    }
    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals('john@hotmail.com', Email::fromString('john@hotmail.com'));
    }
}