<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    // ---- Admin ----
    $app->group('/admin', function (RouteCollectorProxy $group) {
        $group->get('/signin', \App\Action\Admin\AdminSignInPageAction::class)
            ->setName('admin-signin-page');
    });
};
