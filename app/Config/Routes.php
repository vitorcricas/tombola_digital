<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index'); //pagina niccial /
$routes->add('registar', 'Auth::registar');
$routes->add('comerciantes', 'Home::comerciantes');
$routes->add('clientes', 'Auth::login');
$routes->add('faq', 'Home::faq');
$routes->add('adesao', 'Home::adesao');
$routes->post('getCP', 'Home::getCP');
$routes->post('sendMailAdesao', 'Home::sendMailAdesao');
$routes->post('sendContactForm', 'Home::sendContactForm');

$routes->add('sendMail', 'Home::sendMail');

$routes->add('regulamento', 'Home::regulamento');
$routes->add('montras', 'Home::montras');

$routes->add('contato', 'Home::contato');
$routes->add('sorteio', 'Home::sorteio');

//se usar dashboard com clientes::index routes do gcrud deixam de funcionar
$routes->get('dashboard', 'Clientes::dashboard');
$routes->get('dashboardC', 'Comerciantes::dashboard');


//clientes
$routes->group('clientes', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('cupoes', 'Clientes::cupoes');
    //$routes->get('drawInfo', 'Clientes::drawInfo');

    //$routes->get('cupoes/add', 'Clientes::cupoes/add');

    // ...
});

$routes->group('comerciantes', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('cupoes', 'Comerciantes::cupoes');
    $routes->get('listagem', 'Comerciantes::listagem');
    $routes->get('pedidosAdesao', 'Comerciantes::pedidosAdesao');
    $routes->get('quizzes', 'Comerciantes::quizzes');

    $routes->post('confirmMerchant', 'Comerciantes::confirmMerchant');
    //$routes->post('toggleMerchant', 'Comerciantes::toggleMerchant');

    //$routes->get('cupoes/add', 'Clientes::cupoes/add');

    // ...
});

//https://github.com/benedmunds/CodeIgniter-Ion-Auth/blob/4/INSTALLING.md
//ou se faz com um controller Auth ou com routes!!
$routes->group('auth', ['namespace' => 'IonAuth\Controllers'], function ($routes) {
    $routes->add('login', 'Auth::login');
    $routes->get('login_google', 'Auth::login_google');    
    $routes->get('login_facebook', 'Auth::login_facebook');    

    $routes->get('logout', 'Auth::logout');
    $routes->add('forgot_password', 'Auth::forgot_password');
    $routes->add('backoffice', 'Auth::index'); //lista de utilizadores
    $routes->add('create_user', 'Auth::create_user');
    $routes->add('edit_user/(:num)', 'Auth::edit_user/$1');
    $routes->add('create_group', 'Auth::create_group');
    $routes->add('edit_group/(:num)', 'Auth::edit_group/$1');

    $routes->get('activate/(:num)', 'Auth::activate/$1');
    $routes->get('activate/(:num)/(:hash)', 'Auth::activate/$1/$2');
    $routes->add('deactivate/(:num)', 'Auth::deactivate/$1');
    $routes->get('reset_password/(:hash)', 'Auth::reset_password/$1');
    $routes->post('reset_password/(:hash)', 'Auth::reset_password/$1');
    // ...
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
