<?php

namespace App\Action\Admin;

use App\Domain\Foto\Service\FotoUpdateService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FotoUpdateAction 
{
    private $service;
    private $renderer;

    public function __construct(
        FotoUpdateService $service,
        JsonRenderer $renderer,
    ) {
        $this->service = $service;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response, array $args = []): ResponseInterface 
    {
        // Gets item id
        $id = (int)$args['id'];
        // Forms data from request
        $itemData = [
            // Gets uploaded file(s)
            'file' => $request->getUploadedFiles(), 
            // Gets request parameters
            'params' => (array)$request->getParsedBody()
        ];
        // HTTP response
        return $this->renderer->json(
            $response, 
            $this->service->updateById($id, $itemData)
        );
    }
}
