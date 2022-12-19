<?php include_once __DIR__  . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <input
                type="text"
                value="<?php echo $usuario->nombre; ?>"
                name="nombre"
                placeholder="Tu Nombre"
            />
        </div>
        <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <input
                type="text"
                value="<?php echo $usuario->apellido; ?>"
                name="apellido"
                placeholder="Tu Apellido"
            />
        </div>
        <div class="campo">
            <input
                type="email"
                value="<?php echo $usuario->email; ?>"
                name="email"
                placeholder="Tu Email"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>


<?php include_once __DIR__  . '/footer-dashboard.php'; ?>