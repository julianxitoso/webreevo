<?php

// --- Detección de Entorno ---
$is_production = (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'electrocreditosdelcauca.com'));

if ($is_production) {
    // --- CONFIGURACIÓN PARA PRODUCCIÓN ---
    ini_set('session.save_path', '/home/electroc/sessions');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '.electrocreditosdelcauca.com',
        'secure' => true, // Se asume HTTPS en producción
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
} else {
    // --- CONFIGURACIÓN PARA LOCAL ---
    // No se hace nada, se usa la configuración por defecto de PHP.
}

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
        $controller = new HomeController();
        $controller->index();
        break;
    
    case '/dashboard':
        if (!isset($_SESSION['usu_id'])) {
            header('Location: /login');
            exit();
        }
        $controller = new HomeController();
        $controller->dashboard();
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