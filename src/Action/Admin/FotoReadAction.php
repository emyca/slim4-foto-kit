<?php

namespace App\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class FotoReadAction 
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
            'title' => 'Admin | Foto',
            'items' => $data);
    
        $response = $this->twig
            ->render($response, 'admin/admin_fotos.twig', $viewData);

        return $response;    
    }
}
