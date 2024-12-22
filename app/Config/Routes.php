<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // LANDING PAGE

/** ====================== ROUTE FOR AUTH ===================== */
$routes->group("auth", static function (RouteCollection $route) {
    $route->get("login", 'AuthController::index');
    $route->post('pushLogin', 'AuthController::login');
    $route->get('register', 'AuthController::registerPage');
    $route->post('pushRegister', 'AuthController::register');
    $route->get('logout', 'AuthController::logout');
    
});

/** ====================== PROTECTED ROUTE ======================= */
$routes->group('/a', ['filter' => 'auth'], static function (RouteCollection $route) {

    /** ====================== USER ROUTE ======================= */
    //                        VALIDATE ROLE
    $route->group('/', ['filter' => 'role'], static function (RouteCollection $route) {
        $route->view('/', 'pages/posts/post_view');
    });

    /** ====================== ADMIN ROUTE ======================= */
    $route->group('admin', static function (RouteCollection $route) {

        $route->get('/', 'Admin\DashboardController::index');

        $route->group('users', static function (RouteCollection $route) {
            $route->get('/', 'Admin\UserController::index');
        });
    });
});
