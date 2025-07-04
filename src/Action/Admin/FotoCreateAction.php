<?php

namespace App\Action\Admin;

use App\Domain\Foto\Service\FotoCreateService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class FotoCreateAction 
{
    private $service;
    private $renderer;
    
    public function __construct(
        FotoCreateService $service,
        JsonRenderer $renderer,
    ) {
        $this->service = $service;
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request, Response $response): Response 
    {
        // Form data from request
        $itemData = [
            'file' => $request->getUploadedFiles(),
            'params' => (array)$request->getParsedBody()
        ];
        // HTTP response
        return $this->renderer->json(
            $response, 
            $this->service->create($itemData)
        );
    }
}
