<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value="<?php
    echo s( $vendedor->nombre ); ?>"> <!--Name permite leer lo que el usuario escriba-->

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value="<?php
    echo s( $vendedor->apellido ); ?>"> <!--Name permite leer lo que el usuario escriba-->
</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono Vendedor(a)" value="<?php
    echo s( $vendedor->telefono ); ?>"> <!--Name permite leer lo que el usuario escriba-->
</fieldset>