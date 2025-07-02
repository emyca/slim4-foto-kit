<?php

namespace App\Renderer;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

final readonly class TemplateRenderer
{
    public function __construct(
        private Twig $twig
    ) {
    }

     /**
     * Render template.
     *
     * @param ResponseInterface $response The response
     * @param string $template Template pathname relative to templates directory
     * @param array $data Associative array of template variables
     *
     * @return ResponseInterface The response
     */
    public function render(
        ResponseInterface $response, 
        string $template, array $data = []): 
    ResponseInterface
    {
        return $this->twig->render($response, $template, $data);
    }
}