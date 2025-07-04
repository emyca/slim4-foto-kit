<?php

namespace App\Action\Admin;

use App\Domain\Foto\Service\FotoDeleteService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FotoDeleteAction 
{
    private $service;
    private $renderer;

    public function __construct(
        FotoDeleteService $service,
        JsonRenderer $renderer,
    ) {
        $this->service = $service;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response, array $args = []
    ): ResponseInterface 
    {
        // Gets item id
        $id = (int)$args['id'];
        // HTTP response
        return $this->renderer->json(
            $response, 
            $this->service->deleteById($id)
        ); 
    }
}
