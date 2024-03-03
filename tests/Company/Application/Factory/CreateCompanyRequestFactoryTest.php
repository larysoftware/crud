<?php

declare(strict_types=1);

namespace App\Tests\Company\Application\Factory;

use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Factory\CreateCompanyRequestFactory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateCompanyRequestFactoryTest extends TestCase
{
    private CreateCompanyRequestFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new CreateCompanyRequestFactory();
    }

    public function testCreateValidRequest(): void
    {
        $data = [
            'name' => 'Example Company',
            'nip' => '1234567890',
            'address' => '123 Example Street',
            'city' => 'Example City',
            'postcode' => '12345'
        ];

        $request = $this->factory->create($data);

        $this->assertInstanceOf(CreateCompanyRequest::class, $request);
        $this->assertSame($data['name'], $request->name);
        $this->assertSame($data['nip'], $request->nip);
        $this->assertSame($data['address'], $request->address);
        $this->assertSame($data['city'], $request->city);
        $this->assertSame($data['postcode'], $request->postCode);
    }

    public function testCreateRequestWithMissingField(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $data = [
            'name' => 'Example Company',
            'address' => '123 Example Street',
            'city' => 'Example City',
            'postcode' => '12345'
        ];

        $this->factory->create($data);
    }

    public function testCreateRequestWithInvalidTypeField(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $data = [
            'name' => 'Example Company',
            'nip' => 1234567890,
            'address' => '123 Example Street',
            'city' => 'Example City',
            'postcode' => '12345'
        ];

        $request = $this->factory->create($data);
    }
}