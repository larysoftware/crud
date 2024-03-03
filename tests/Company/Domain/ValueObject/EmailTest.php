<?php
declare(strict_types=1);

namespace App\Tests\Company\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use App\Company\Domain\ValueObject\Email;
use InvalidArgumentException;

use function str_repeat;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email('test@example.com');
        $this->assertInstanceOf(Email::class, $email);
    }

    public function testInvalidEmailFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid_email_format');
    }

    public function testExceedingMaxLength(): void
    {
        $longEmail = str_repeat('a', 256) . '@example.com';
        $this->expectException(InvalidArgumentException::class);
        new Email($longEmail);
    }
}