<?php
#FrontController

#En caso de que XAMP no tenga la opcion de mostrar errores activas esta es la forma de mostrar los errores
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

#Autoload
require_once '../vendor/autoload.php';

# Inicializa la sesion
session_start();

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
$map->get('listaUsuarios', '/zinobe_usuarios/lista', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
    'auth' => true
]);

$map->get('index', '/zinobe_usuarios/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
    'auth' => true
]);

$map->get('registrate', '/zinobe_usuarios/registrate', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'create'
]);

$map->get('loginForm', '/zinobe_usuarios/iniciar-sesion', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'iniciarSesion'
]);

$map->post('auth', '/zinobe_usuarios/auth', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'authSesion'
]);

$map->get('logout', '/zinobe_usuarios/cerrar-sesion', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'logout'
]);

$map->post('guardarUsuario', '/zinobe_usuarios/usuario/store', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'store'
]);

$map->post('buscador', '/zinobe_usuarios/buscar', [
    'controller' => 'App\Controllers\UsuarioController',
    'action' => 'buscador'
]);



$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if(!$route) { echo "No encontro ruta"; } 
else {
    $handlerData = $route->handler;
    $controllerName = new $handlerData['controller'];
    $actionName = $handlerData['action'];
    $authRequired = $handlerData['auth'] ?? false;
    
    $sessionUserId = $_SESSION['userId'] ?? null;
    if($authRequired && !$sessionUserId){
        $controllerName = "App\Controllers\UsuarioController";
        $actionName = "iniciarSesion";
    }

    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    # Obtenemos los encabezados de nuestra respuesta
    foreach($response->getHeaders() as $name => $values){
        foreach($values as $value){
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}

?>