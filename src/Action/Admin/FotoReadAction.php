<?php

namespace App\Action\Admin;

use App\Domain\Foto\Service\FotoReadService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class FotoReadAction 
{
    private $service;
    private $twig;

    public function __construct(
        FotoReadService $service,
        Twig $twig, 
    ) {
        $this->service = $service;
        $this->twig = $twig;
    }

    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response): ResponseInterface 
    {
        $data = $this->service->readAll();
        $viewData = array(
            'title' => 'Admin | Foto',
            'items' => $data);
    
        // This header prevents visiting protected page 
        // after logout using browser history or back button.
        $response = $response->withHeader(
            'Cache-Control', 'no-store'
        );    
        $response = $this->twig
            ->render($response, 'admin/admin_fotos.twig', $viewData);

        return $response;    
    }
}
