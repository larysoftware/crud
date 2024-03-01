<?php

declare(strict_types=1);

namespace App\Shared\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class WelcomeController extends AbstractController
{
    public function index(): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => 'Welcome'
            ]
        );
    }
}
