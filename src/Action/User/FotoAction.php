<?php

namespace App\Action\User;

use App\Domain\Foto\Service\FotoReadService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class FotoAction 
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
            'title' => 'Foto Kit',
            'items' => $data);
    
        $response = $this->twig
            ->render($response, 'user/fotos.twig', $viewData);

        return $response;    
    }
}
