<?php

namespace Model;

class ingresante extends ActiveRecord {
    protected static $tabla = 'ingresantes';
    protected static $columnaDB = ['DNI', 'nombreCompleto', 'email', 'password', 'token', 'confirmacion'];

    public function __construct($args = [])
    {
        $this->DNI = $args ['DNI'] ?? null;
        $this->nombreCompleto = $args ['nombreCompleto'] ?? null;
        $this->email = $args ['email'] ?? null;
        $this->password = $args ['password'] ?? null;
        $this->password2 = $args ['password2'] ?? null;
        $this->token = $args ['token'] ?? null;
        $this->confirmacion = $args ['confirmacion'] ?? null;        
    }

    // Validación para cuentas nuevas
    public function validarNuevaCuenta(){

        if(!$this->$nombreCompleto) {
            self::$alertas['error'][] = 'El Nombre Completo es obligatorio';
        }
        if(!$this->$email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }
        if(!$this->$password) {
            self::$alertas['error'][] = 'La Contraseña es obligatoria';
        }
        if(strlen($this->$password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 6 carácteres';
        }
        if($this->$password !== $this->$password2) {
            self::$alertas['error'][] = 'Las Contraseñas no coinciden';
        }
        return self::$alertas;
    }
}