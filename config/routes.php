<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Categorias', 'action' => 'home']);


    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    
    $routes->connect('/c/*', ['controller'=>'Categorias', 'action'=>'categoria']);
    $routes->connect('/sc/*', ['controller'=>'Categorias', 'action'=>'subcategoria']);
    $routes->connect('/sclista/*', ['controller'=>'Categorias', 'action'=>'subcategorialista']);
    $routes->connect('/p/*', ['controller'=>'Productos', 'action'=>'detalle']);
    $routes->connect('/confirmacion/*', ['controller'=>'Productos', 'action'=>'confirmacion']);
    $routes->connect('/wishlist', ['controller'=>'Productos', 'action'=>'carrito']);
    $routes->connect('/pedido', ['controller'=>'Productos', 'action'=>'pedido']);
    
    
    $routes->connect('/buscar/*', ['controller'=>'Productos', 'action'=>'buscar']);


    $routes->connect('/pedido/*', ['controller'=>'Productos', 'action'=>'pedido']);

    $routes->connect('/list-sucursales', ['controller' => 'Sucursales', 'action' => 'index']);
    $routes->connect('/sucursales', ['controller' => 'Pages', 'action' => 'sucursales']);
    $routes->connect('/formas-de-pago/*', ['controller' => 'Pages', 'action' => 'formasDePago']);
    $routes->connect('/contactanos/*', ['controller' => 'Pages', 'action' => 'contactanos']);
    $routes->connect('/acerca-de/*', ['controller' => 'Pages', 'action' => 'acercaDe']);
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});

Router::scope(
    '/bookmarks',
    ['controller' => 'Bookmarks'],
    function ($routes) {
        $routes->connect('/tagged/*', ['action' => 'tags']);
    }
);

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();

Router::extensions('json');
