<?php

namespace App\Action\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Renderer\TemplateRenderer;

final readonly class AdminSignInPageAction 
{
    public function __construct(
        private TemplateRenderer $templateRenderer
    ) {
    }

    public function __invoke(
        Request $request, 
        Response $response): 
    Response 
    {
        $data = array(
            'title' => 'Admin | Sign In'
        );
        return $this->templateRenderer->render(
            $response, 'admin/admin_signin_form.twig', $data);    
    }
}
