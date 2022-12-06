<div class="contenedor crear">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta</p>

        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/crear">
            <div class="campo">
                <label for="nombreCompleto">Nombre Completo</label>
                <input 
                    type="text"
                    id="nombreCompleto"
                    placeholder="Tu Nombre Completo"
                    name="nombreCompleto"
                    value="<?php echo $ingresante->nombreCompleto; ?>"
                />
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    value="<?php echo $ingresante->email; ?>"
                />
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Contraseña"
                    name="password"
                />
            </div>

            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite tu Contraseña"
                    name="password2"
                />
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">Iniciar Sesión</a>
            <a href="/olvide">Recuperar Contraseña</a>
        </div>
    </div> <!--.contenedor-sm -->
</div>