<?php

namespace Controllers;

use MVC\Router;

class DashboardController {
    public static function index(Router $router) {

        session_start();
        
        $router->render('dashboard/index', [

        ]);

    }

    public static function crear_proyecto(Router $router) {
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto'
        ]);
    }

    public static function perfil(Router $router) {
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }

    public static function cambiar_password(Router $router) {
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password'
        ]);
    }
}