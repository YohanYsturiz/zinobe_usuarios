<?php
#FrontController

#En caso de que XAMP no tenga la opcion de mostrar errores activas esta es la forma de mostrar los errores
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

#Autoload
require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'zinobedb',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/zinobe_usuarios/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);

$map->get('registrate', '/zinobe_usuarios/registrate', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'create'
]);

$map->post('guardarUsuario', '/zinobe_usuarios/usuario/store', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'store'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if(!$route) echo "No encontro ruta";
else {
    $handlerData = $route->handler;
    $controllerName = new $handlerData['controller'];
    $actionName = $handlerData['action'];
    
    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    echo $response->getBody();
}

?>