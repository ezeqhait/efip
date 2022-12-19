<?php

namespace Model;

class ingresante extends ActiveRecord {
    protected static $tabla = 'ingresante';
    protected static $columnasDB = ['id', 'dni', 'nombre', 'apellido', 'email', 'password', 'token', 'confirmacion'];

    public function __construct($args = [])
    {
        $this->id = $args ['id'] ?? null;
        $this->dni = $args ['dni'] ?? '';
        $this->nombre = $args ['nombre'] ?? '';
        $this->apellido = $args ['apellido'] ?? '';        
        $this->email = $args ['email'] ?? '';
        $this->password = $args ['password'] ?? '';
        $this->password2 = $args ['password2'] ?? '';
        $this->password_actual = $args ['password_actual'] ?? '';
        $this->password_nuevo = $args ['password_nuevo'] ?? '';        
        $this->token = $args ['token'] ?? '';
        $this->confirmacion = $args ['confirmacion'] ?? 0;       
    }

        // Validar el Login de ingresantes
        public function validarLogin() {
            if(!$this->email) {
                self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
            }
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                self::$alertas['error'][] = 'Email no válido';
            }
            if(!$this->password) {
                self::$alertas['error'][] = 'El Password no puede ir vacía';
            }
            return self::$alertas;
    
        }

    // Validación para cuentas nuevas
    public function validarNuevaCuenta() {
        
        if(!$this->dni) {
            self::$alertas['error'][] = 'El DNI del Ingresante es Obligatorio';
        }        
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Ingresante es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido del Ingresante es Obligatorio';
        }        
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Ingresante es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }
        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function validar_perfil() {
        if(!$this->dni) {
            self::$alertas['error'][] = 'El DNI es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}