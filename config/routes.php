<?php

use App\Middleware\AdminJwtAuthorizationMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    // ---- Admin ----
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->get('/signin', \App\Action\Admin\AdminSignInPageAction::class)
            ->setName('admin-signin-page');
        $group->post('/auth', \App\Action\Admin\AdminAuthAction::class);
        $group->group('/fotos', function (RouteCollectorProxy $group) {
            $group->get('', \App\Action\Admin\FotoReadAction::class);
            $group->post('', \App\Action\Admin\FotoCreateAction::class);
            $group->post('/{id}', \App\Action\Admin\FotoUpdateAction::class);
            $group->delete('/{id}', \App\Action\Admin\FotoDeleteAction::class);
        })->add(AdminJwtAuthorizationMiddleware::class);
        $group->get('/logout', \App\Action\Admin\AdminLogOutAction::class);
    });

    // ---- User ----
    $app->get('/', \App\Action\User\FotoAction::class);
};
