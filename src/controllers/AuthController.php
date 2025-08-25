<?php

// Incluir el autoloader de Composer para poder usar la librería JWT
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// Usar la clase JWT
use Firebase\JWT\JWT;

class AuthController {

    /**
     * Muestra una página con un botón para simular el inicio de sesión.
     */
    public function showLogin() {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de Prueba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f5f5f5; }
        .login-box { padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1 class="h3 mb-3 fw-normal">Simulador de Login</h1>
        <p>Haz clic para entrar con un usuario de prueba.</p>
        <form action="/auth/login-action" method="post">
            <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
HTML;
        echo $html;
    }

    /**
     * Procesa el login, crea la sesión/token y redirige al dashboard.
     */
    public function processTestLogin() {
        // 1. Crear la sesión local para la intranet
        $_SESSION['is_jefe'] = 0;
        $_SESSION['usu_id'] = 1;
        $_SESSION['usu_nom'] = 'Alexander'; 
        $_SESSION['usu_ape'] = 'Pardo'; 
        $_SESSION['rol_id'] = 2; 
        $_SESSION['rol_id_real'] = 3;
        $_SESSION['dp_id'] = null;
        $_SESSION['car_id'] = null;

        // 2. Generar el Token JWT para los otros servicios
        $secret_key = 'ESTA-ES-UNA-CLAVE-DE-EJEMPLO-CAMBIALA-POR-ALGO-SEGURO';
        $issuer_claim = "intranet.electrocreditosdelcauca.com";
        $audience_claim = "electrocreditosdelcauca.com";
        $issuedat_claim = time();
        $expire_claim = $issuedat_claim + 3600; // 1 hora

        $payload = [
            'iss' => $issuer_claim,
            'aud' => $audience_claim,
            'iat' => $issuedat_claim,
            'exp' => $expire_claim,
            'data' => [
                'id' => 1,
                'email' => 'jhonalexander2016.com@gmail.com',
                'cedula' => '1061701851'
            ]
        ];
        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        // 3. Guardar el token en la sesión para usarlo en el dashboard
        $_SESSION['sso_token'] = $jwt;

        // 4. Redirigir a la página de inicio
        header('Location: /');
        exit();
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout() {
        session_destroy();
        header('Location: /login');
        exit();
    }
}