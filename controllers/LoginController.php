<?php

namespace Controllers;

use Classes\Email;
use Model\ingresante;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ingresante = new ingresante($_POST);
            $alertas = $ingresante->validarLogin();
            
            if(empty($alertas)) {
                // Verificar quel el ingresante exista
                $ingresante = ingresante::where('email', $ingresante->email);
                if(!$ingresante || !$ingresante->confirmacion ) {
                    ingresante::setAlerta('error', 'El ingresante No Existe o no esta confirmado');
                } else {
                    // El ingresante existe
                    if( password_verify($_POST['password'], $ingresante->password) ) {
                        
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $ingresante->id;
                        $_SESSION['nombre'] = $ingresante->nombre;
                        $_SESSION['email'] = $ingresante->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        header('Location: /dashboard');
                    } else {
                        ingresante::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }

        $alertas = ingresante::getAlertas();
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear(Router $router) {
        $alertas = [];
        $ingresante = new ingresante;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ingresante->sincronizar($_POST);
            $alertas = $ingresante->validarNuevaCuenta();

            if(empty($alertas)) {
                $existeingresante = ingresante::where('email', $ingresante->email);

                if($existeingresante) {
                    ingresante::setAlerta('error', 'El ingresante ya esta registrado');
                    $alertas = ingresante::getAlertas();
                } else {
                    // Hashear el password
                    $ingresante->hashPassword();

                    // Eliminar password2
                    unset($ingresante->password2);

                    // Generar el Token
                    $ingresante->crearToken();

                    // Crear un nuevo ingresante
                    $resultado =  $ingresante->guardar();

                    // Enviar email
                    $email = new Email($ingresante->email, $ingresante->nombre, $ingresante->token);
                    $email->enviarConfirmacion();
                    

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta en UpTask', 
            'ingresante' => $ingresante, 
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ingresante = new ingresante($_POST);
            $alertas = $ingresante->validarEmail();

            if(empty($alertas)) {
                // Buscar el ingresante
                $ingresante = ingresante::where('email', $ingresante->email);

                if($ingresante && $ingresante->confirmacion) {

                    // Generar un nuevo token
                    $ingresante->crearToken();
                    unset($ingresante->password2);

                    // Actualizar el ingresante
                    $ingresante->guardar();

                    // Enviar el email
                    $email = new Email( $ingresante->email, $ingresante->nombre, $ingresante->token );
                    $email->enviarInstrucciones();


                    // Imprimir la alerta
                    ingresante::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                } else {
                    ingresante::setAlerta('error', 'El ingresante no existe o no esta confirmado');
                }
            }
        }

        $alertas = ingresante::getAlertas();

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token) header('Location: /');

        // Identificar el ingresante con este token
        $ingresante = ingresante::where('token', $token);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $ingresante->sincronizar($_POST);

            // Validar el password
            $alertas = $ingresante->validarPassword();

            if(empty($alertas)) {
                // Hashear el nuevo password
                $ingresante->hashPassword();

                // Eliminar el Token
                $ingresante->token = null;

                // Guardar el ingresante en la BD
                $resultado = $ingresante->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = ingresante::getAlertas();
        // Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');
        // Encontrar al ingresante con este token
        $ingresante = ingresante::where('token', $token);


        
        if(empty($ingresante)) {
            // No se encontró un ingresante con ese token
            ingresante::setAlerta('error', 'Token Inválido');
        } else {
            // Confirmar la cuenta
            $ingresante->token = null;
            unset($ingresante->password2);
            unset($ingresante->password_actual);
            unset($ingresante->password_nuevo);
            $ingresante->confirmacion = 1;          
            // Guardar en la BD
            $ingresante->guardar();

            debuguear($ingresante);

            ingresante::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        $alertas = ingresante::getAlertas();
        
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta DinoTask',
            'alertas' => $alertas
        ]);
    }
}