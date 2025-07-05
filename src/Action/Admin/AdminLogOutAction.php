<?php

namespace App\Action\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\Config\Configuration;
use Slim\Routing\RouteContext;

final readonly class AdminLogOutAction 
{
    public function __construct(
        private Configuration $config,
    ) {
    }

    public function __invoke(
        Request $request, 
        Response $response): 
    Response 
    {
        $cookieName = $this->config->getString('jwt.cookie_name');
        if (isset($_COOKIE[$cookieName])) {
            unset($_COOKIE[$cookieName]);
            // Sets cookie empty value and old timestamp (24 hours back) 
            // to delete cookie. 
            // The timestamp may depends on server default timezone.
            setcookie($cookieName, '', time() - (60 * 60 * 24));
        }
        
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('admin-signin-page');
        
        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }
}
