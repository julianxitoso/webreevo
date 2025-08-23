<?php

// FORZAR LA CONFIGURACIÓN DE SESIÓN PARA ASEGURAR COMPATIBILIDAD
ini_set('session.save_path', '/home/electroc/sessions');

// CONFIGURACIÓN DE LA SESIÓN COMPARTIDA
// El dominio debe empezar con un punto para ser válido en todos los subdominios.
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '.electrocreditosdelcauca.com',
    'secure' => isset($_SERVER["HTTPS"]), // Enviar solo sobre HTTPS si está disponible
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Iniciar la sesión en todas las páginas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the root path of the project
define('ROOT_PATH', __DIR__ . '/');

// Incluir los controladores
require_once ROOT_PATH . 'src/controllers/HomeController.php';
require_once ROOT_PATH . 'src/controllers/AuthController.php';

// Analizar la URL solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Enrutador simple
switch ($requestPath) {
    case '/':
    case '/index.php':
        // Proteger esta ruta, verificando la nueva variable de sesión
        if (!isset($_SESSION['usu_id'])) {
            header('Location: /login');
            exit();
        }
        $controller = new HomeController();
        $controller->index();
        break;
    
    case '/login':
        $controller = new AuthController();
        $controller->showLogin();
        break;

    case '/auth/login-action':
        $controller = new AuthController();
        $controller->processTestLogin();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "La página que buscas no existe.";
        break;
}