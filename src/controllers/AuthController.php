<?php

class AuthController {

    /**
     * Muestra una página con un botón para simular el inicio de sesión.
     */
    public function showLogin() {
        // Más adelante, esto puede ser un formulario de login real.
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
     * Procesa el login de prueba y crea la sesión COMPLETA.
     * La sesión ya está iniciada por index.php
     */
    public function processTestLogin() {
        // Simular una autenticación COMPLETA con todas las variables que la mesa de ayuda espera.
        $_SESSION['is_jefe'] = 0; // 0 para no, 1 para sí
        $_SESSION['usu_id'] = 1; // Usamos integer como en la sesión real
        $_SESSION['usu_nom'] = 'Alexander'; 
        $_SESSION['usu_ape'] = 'Pardo'; 
        $_SESSION['rol_id'] = 2; 
        $_SESSION['rol_id_real'] = 3;
        $_SESSION['dp_id'] = null;
        $_SESSION['car_id'] = null;

        // Redirigir a la página principal
        header('Location: /');
        exit();
    }

    /**
     * Cierra la sesión del usuario.
     * La sesión ya está iniciada por index.php
     */
    public function logout() {
        session_destroy();
        
        header('Location: /login');
        exit();
    }
}