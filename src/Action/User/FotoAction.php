<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class FotoAction 
{
    private $twig;

    public function __construct(
        Twig $twig, 
    ) {
        $this->twig = $twig;
    }

    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response): ResponseInterface 
    {
        $data = array();
        $viewData = array(
            'title' => 'Foto Kit',
            'items' => $data);
    
        $response = $this->twig
            ->render($response, 'user/fotos.twig', $viewData);

        return $response;    
    }
}
