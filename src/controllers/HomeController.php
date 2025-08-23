<?php

class HomeController {
    /**
     * Muestra la página principal.
     */
    public function index() {
        require_once ROOT_PATH . 'src/views/index.php';
    }
}