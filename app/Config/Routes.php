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

        /** ====================== MASTER ROUTE ======================= */
        $route->group('master', static function (RouteCollection $route) {

            /** ====================== QUESTION ROUTE ======================= */
            $route->get('questions', 'Admin\QuestionController::index');
            $route->get('questions/add', 'Admin\QuestionController::add');
            $route->post('questions/insert', 'Admin\QuestionController::insert');
            $route->get('questions/edit/(:num)', 'Admin\QuestionController::edit/$1');
            $route->post('questions/update/(:num)', 'Admin\QuestionController::update/$1');
            // $route->get('question/delete/(:num)', 'Admin\QuestionController::delete/$1');
        });

        /** ====================== USER ROUTE ======================= */
        $route->group('users', static function (RouteCollection $route) {
            $route->get('/', 'Admin\UserController::index');
            $route->get('add', 'Admin\UserController::add');
            $route->post('insert', 'Admin\UserController::insert');
            $route->get('edit/(:num)', 'Admin\UserController::edit/$1');
            $route->post('update/(:num)', 'Admin\UserController::update/$1');
            $route->get('delete/(:num)', 'Admin\UserController::delete/$1');
        });

        /** ====================== QUESTION ROUTE ======================= */
        $route->group('question-periods', static function (RouteCollection $route) {
            $route->get('/', 'Admin\QuestionPeriodController::index');
            $route->get('add', 'Admin\QuestionPeriodController::add');
            $route->post('insert', 'Admin\QuestionPeriodController::insert');
            $route->get('edit/(:num)', 'Admin\QuestionPeriodController::edit/$1');
            $route->post('update/(:num)', 'Admin\QuestionPeriodController::update/$1');
            $route->get('delete/(:num)', 'Admin\QuestionPeriodController::delete/$1');
        });
    });
});
