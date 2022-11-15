<?php

//base de datos
    //require '../../includes/app.php';

    require '../../includes/config/database.php';
    $db = conectarDB();

    //consultar para obtener vendedores
    $consulta = "SELECT *FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo  Mensajes de errores
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

    //Ejecutrar el codigo de usuario
    if($_SERVER['REQUEST_METHOD'] ==='POST'){
        //echo "<pre>";
        //var_dump($_POST);
        //echo"</pre>";

        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedorId = $_POST['vendedor'];
        $creado = date('Y/m/d');

        if(!$titulo) {
            $errores[] = "Debes de añadir un titulo";
        }

        if(!$precio) {
            $errores[] = "El precio es Obligatorio";
        }
        if (strlen($descripcion) < 50) {
            $errores[] = "La descripcion es obligatoria";
        }
        if(!$habitaciones) {
            $errores[] = "El numero de las habitaciones es Obligatorio";
        }
        if(!$wc) {
            $errores[] = "El numero de los baños es Obligatorio";
        }
        if(!$estacionamiento) {
            $errores[] = "El numero de lugar de estacionamiento es Obligatorio";
        }
        if(!$vendedorId) {
            $errores[] = "Eligue un vendedor";
        }
        

        //echo "<pre>";
        //var_dump($_POST);
        //echo"</pre>";

        //Revisar arreglo de errores

        if(empty($errores)){
            $query = " INSERT INTO propiedades (titulo,precio, descripcion, habitaciones, wc, estacionamiento, creado,
            vendedorId) VALUES ( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId' )";
            
    
            //echo $query;
    
            $resultado =  mysqli_query($db, $query);
    
            if($resultado){
                // Redireccionar 

                header('Locaition: /admin ');
            }
        }
        

    }


    require '../../includes/funciones.php';

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error" >
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $title; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="imagen/jpeg, imagen/png">

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion de la Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                
                <select name="vendedor" >
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']?>"><?php echo $vendedor['nombre'] ." ". $vendedor['apellido']; ?></option>
                        <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php
    incluirTemplate('footer');
?>