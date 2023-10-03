<?php

try {

    /**
     * Login Routes
     */
    $router->post('/login', 'AuthController:login');

    /**
     * Products Routes
     */
    $router->get('/products', 'ProductController:getAll');
    $router->get('/products/(:id)', 'ProductController:getById');
    $router->post('/products', 'ProductController:store');
    $router->put('/products/(:id)', 'ProductController:update');
    $router->delete('/products/(:id)', 'ProductController:delete');

    /**
     * Categories Routes
     */
    $router->get('/categories', 'CategoryController:getAll');
    $router->get('/categories/(:id)', 'CategoryController:getById');
    $router->post('/categories', 'CategoryController:store');
    $router->put('/categories/(:id)', 'CategoryController:update');
    $router->delete('/categories/(:id)', 'CategoryController:delete');

    /**
     * Sales Routes
     */
    $router->get('/sales', 'SaleController:getAll');
    $router->get('/sales/(:id)', 'SaleController:getById');
    $router->post('/sales', 'SaleController:store');
    $router->put('/sales/(:id)', 'SaleController:update');
    $router->delete('/sales/(:id)', 'SaleController:delete');
    
    /**
     * Users Routes
     */
    $router->get('/users', 'UserController:getAll');
    $router->get('/users/(:id)', 'UserController:getById');
    $router->post('/users', 'UserController:store');
    $router->put('/users/(:id)', 'UserController:update');
    $router->delete('/users/(:id)', 'UserController:delete');
} catch (\Throwable $th) {
    throw $th;
}
