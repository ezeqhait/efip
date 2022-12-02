<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    public static function logout() {
        echo "Desde Logout";
    }

    public static function crear(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta'
        ]);
        
    }
   
    public static function olvide(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
        
        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvidé mi pass'
        ]);

    }
   
    public static function reestablecer(Router $router) {
        echo "Desde Reestablecer";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
        
        // Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Restablecer pass'
        ]);

    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada con éxito'
        ]);
    }

    public static function confirmar(Router $router) {
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);
    }

}