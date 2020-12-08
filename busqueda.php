<?php
    //Realizamos la conexion
    require_once("conexionBD.php");
    $conexion = new Conectar();
    //Sacamos todos los niños
    $todosNinos = $conexion->selectAll("ninios");
    //Sacamos todos los juguetes
    $todosJuguetes = $conexion->selectAll("juguetes");
    //Dejamos valores por defecto
    $lista = false;
    $listaVacia = true;
    $resultadoInsert = true;
    $nino = true;
    //Cuando pulsamos pulsamos en ver lista
    if(isset($_POST['nino'])){
        $nino = $conexion->select("ninios",$_POST['nino']);
        $FK = $conexion->selectAllFK($_POST['nino']);
        $lista = true;
    }
    //Filtramos los id que se van a introducir en el insert
    $insert['idNinio'] = (int) filter_input(INPUT_POST,'idNinio',FILTER_SANITIZE_STRING);
    $insert['idJuguete'] = (int) filter_input(INPUT_POST,'juguete',FILTER_SANITIZE_STRING);
    //Cuando pulsamos en añadir a la lista
    if(isset($_POST['juguete'])){
        $resultadoInsert = $conexion->insertToy($insert['idNinio'],$insert['idJuguete']);
        $nino = $conexion->select("ninios",$_POST['idNinio']);
        $FK = $conexion->selectAllFK($_POST['idNinio']);
        $lista = true;
        //Damos mensaje si se ha añadido correctamente
        if($resultadoInsert==true){
            $msgExito = "Se ha añadido correctamente a la lista de deseos.";
        }
    }

    //Controlamos errores
    $error = (int)filter_input(INPUT_GET,'e',FILTER_SANITIZE_STRING);
    if($error==22){
        $msgError = "El niño que estás buscando no existe.";
        $lista = false;
        $nino=true;
    }else if($error==33){
        $msgError = "El niño o el juguete que has introducido no son válidos. No se ha añadido nada a la lista.";
        $lista = false;
        $resultadoInsert = true;
    }
    //Redirigimos dando error si encontramos problemas
    if($nino==null){
        header('Location:busqueda.php?e=22');
    }
    if($resultadoInsert==false){
        header('Location:busqueda.php?e=33');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Búsqueda</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    </head>
    <body>
    <div style="min-height: 100vh;" class="container-fluid h-100vh p-5 bg-dark">
        <?php 
        //Se muestran mensajes de exito o error cuando se establezcan
        if(isset($msgExito)){?>
            <div class="alert alert-success" role="alert">
                <?php echo $msgExito; ?>
            </div>
        <?php }else if(isset($msgError)){ ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $msgError; ?>
            </div>
        <?php } ?>
        <form action="busqueda.php" method="post">
            <div class="form-row col-2">
                <div class="form-group">
                    <label class="text-white">Selecciona el niño:</label>
                    <select name="nino" class="form-control">
                        <?php //Lista desplegable para poder seleccionar entre todos los niños
                            while($row = $todosNinos->fetch_assoc()){ ?>
                            <option value="<?php echo $row['idNinio'] ?>"><?php echo $row['nombreNinio'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Ver lista del niño" class="btn btn-primary">
                </div>
            </div>
        </form>
        <!-- Se muestra la lista y la opción de añadir regalos -->
        <?php if($lista==true){ ?>
            <h1 class="text-white"><?php echo "Lista de deseos de ".$nino['nombreNinio']; ?></h1>
            <ul class="list-group">
            <?php //Mostramos la lista con los deseos del niño seleccionado
                while($fila = $FK->fetch_assoc()){ ?>
                <li class="list-group-item col-6"><?php
                    $juguete = $conexion->select("juguetes",$fila['idJugueteFK']);
                    echo $juguete['nombreJuguete'];
                    $listaVacia=false;
                ?></li>
            <?php } ?>
            </ul>
            <!-- Si no ha pedido ningún juguete se muestra esto -->
            <?php if($listaVacia==true){ ?>
                <ul class="list-group">
                    <li class="list-group-item col-6"><?php echo "No ha pedido nada" ?></li>
                </ul>
            <?php } ?>
            <hr class="bg-light">
            <form action="busqueda.php" method="post">
                <div class="form-row col-5">
                    <div class="form-group">
                        <!-- Se muestran todos los juguetes y se selecciona uno para añadirlo al niño actual -->
                        <label class="text-white">Selecciona el juguete:</label>
                        <select name="juguete" class="form-control">
                            <?php while($filaJuguete = $todosJuguetes->fetch_assoc()){ ?>
                                <option value="<?php echo $filaJuguete['idJuguete'] ?>"><?php echo $filaJuguete['nombreJuguete'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" name="idNinio" value="<?php echo $nino['idNinio']; ?>" hidden>
                        <br>
                        <input type="submit" value="Añadir a la lista" class="btn btn-primary">
                    </div>
                </div>
            </form>
        <?php } ?>
        <hr class="bg-light">
        <a class="btn btn-success" href="regalos.php">Juguetes</a>
        <a class="btn btn-success" href="reyes.php">Reyes Magos</a>
    </div>
    </body>
</html>