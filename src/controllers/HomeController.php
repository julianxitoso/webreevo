<?php

class HomeController {
    /**
     * Muestra la página de bienvenida y, si el usuario ha iniciado sesión,
     * le pasa los datos para mostrar los enlaces de servicios.
     */
    public function index() {
        // Comprobar si hay una sesión activa
        $isLoggedIn = isset($_SESSION['usu_id']);
        $userName = null;
        $ssoToken = null;

        if ($isLoggedIn) {
            $userName = $_SESSION['usu_nom'] ?? 'Usuario';
            $ssoToken = $_SESSION['sso_token'] ?? '';
        }

        // La vista `index.php` ahora tendrá acceso a $isLoggedIn, $userName y $ssoToken
        require_once ROOT_PATH . 'src/views/index.php';
    }

    /**
     * Muestra el dashboard del usuario con los enlaces de SSO.
     * NOTA: Esta ruta ya no es la principal después del login, pero puede seguir existiendo
     * si se quiere un dashboard separado en el futuro.
     */
    public function dashboard() {
        // Recuperamos los datos del usuario y el token de la sesión
        $userName = $_SESSION['usu_nom'] ?? 'Usuario';
        $ssoToken = $_SESSION['sso_token'] ?? '';

        require_once ROOT_PATH . 'src/views/dashboard.php';
    }
}
