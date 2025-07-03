<?php

namespace App\Action\Admin;

use App\Domain\AdminAuth\Service\AdminAuthService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class AdminAuthAction 
{
    public function __construct(
        private AdminAuthService $service,
        private JsonRenderer $renderer,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response 
    {
        // Gets request body parameters        
        $adminAuthData = (array)$request->getParsedBody();
        // HTTP response
        return $this->renderer->json(
            $response, 
            $this->service->auth($adminAuthData)
        );
    }
}
