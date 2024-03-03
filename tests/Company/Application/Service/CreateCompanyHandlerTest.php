<?php

declare(strict_types=1);

namespace App\Tests\Company\Application\Service;

use App\Company\Application\Dto\CreateCompanyRequest;
use App\Company\Application\Service\CreateCompanyHandler;
use App\Company\Domain\Exception\NipAlreadyExistsException;
use App\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Company\Domain\ValueObject\CompanyId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CreateCompanyHandlerTest extends TestCase
{
    public function testCreateCompany(): void
    {
        $repositoryMock = $this->createMock(CompanyRepositoryInterface::class);
        $repositoryMock->expects($this->once())->method('save')->willReturn(new CompanyId(12));
        $companyHandler = new CreateCompanyHandler($repositoryMock);
        $response = $companyHandler->handle(new CreateCompanyRequest(
            'test',
            '12323',
            '2323',
            'sdsd',
            '26-111'
        ));
        $this->assertSame(12, $response->companyId);
    }

    public function testCreateCompanyWithInvalidNip(): void
    {
        $repositoryMock = $this->createMock(CompanyRepositoryInterface::class);
        $repositoryMock->expects($this->never())->method('save');

        $companyHandler = new CreateCompanyHandler($repositoryMock);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('NIP length cannot exceed 15 character');
        $companyHandler->handle(new CreateCompanyRequest(
            'test',
            '1232334234324234234324234324234',
            '2323',
            'sdsd',
            '26-111'
        ));
    }

    public function testCreateCompanyWithException(): void
    {
        $repositoryMock = $this->createMock(CompanyRepositoryInterface::class);
        $repositoryMock->expects($this->once())->method('save')->willThrowException(new NipAlreadyExistsException);

        $companyHandler = new CreateCompanyHandler($repositoryMock);

        $this->expectException(NipAlreadyExistsException::class);
        $companyHandler->handle(new CreateCompanyRequest(
            'test',
            '12323',
            '2323',
            'sdsd',
            '26-111'
        ));
    }
}