<?php

namespace App\Middleware;

use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Selective\Config\Configuration;

final class AdminJwtAuthorizationMiddleware implements MiddlewareInterface
{
    private $renderer;
    private $responseFactory;
    private $config;

    public function __construct(
        JsonRenderer $renderer,
        ResponseFactoryInterface $responseFactory,
        Configuration $config,
    ) {
        $this->renderer = $renderer;
        $this->responseFactory = $responseFactory;
        $this->config = $config;
    }

    public function process(Request $request, 
        RequestHandler $handler): Response
    {
        $cookieName = $this->config->getString('jwt.cookie_name');
        $redirectUrl = $this->config->getString('url.adminSignIn');
        if(!isset($_COOKIE[$cookieName])) {
            // Create a new response using the response factory
            $response = $this->responseFactory->createResponse();
            // Checks if the request is AJAX-request 
            if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                // JSON response to AJAX-request (create/update/delete resourse)               
                return $this->renderer->json(
                    $response, 
                    array(
                        'status' => 401, 
                        'success' => false,
                        'message' => 'Unauthorized!',
                        // Because of AJAX, redirect url sent in JSON response
                        'url' => $this->config->getString('url.adminSignIn')
                    )
                );
            }
            // Just redirects if resourse(s) are not allowed to be read
            return $response
                ->withHeader('Location', $redirectUrl)
                ->withStatus(302);
        }
        // Proceed with the next middleware
        return $handler->handle($request);
    }
}
