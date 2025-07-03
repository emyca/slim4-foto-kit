<?php

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
        });
    });

    // ---- User ----
    $app->get('/', \App\Action\User\FotoAction::class);
};
