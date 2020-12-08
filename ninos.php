<?php
    //Accedemos al archivo php y cargamos la clase conectar
    require_once("conexionBD.php");
    $conexion = new Conectar();
    //Extraemos todos los niños de la base de datos ordenados por nombre
    $query = $conexion->selectAll("ninios","nombreNinio");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Niños</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    </head>
    <body>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Fecha de nacimiento</th>
                    <th scope="col">Buen comportamiento</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //Número para las filas de la tabla
                $num=1;
                //Transformamos el resultado de la sentencia en un array asociativo.
                while($row = $query->fetch_assoc()){ ?>
                    <tr>
                        <th scope="row"><?php echo $num ?></th>
                        <td><?php echo $row['nombreNinio']; ?></td>
                        <td><?php echo $row['apellidosNinio']; ?></td>
                        <td><?php 
                        $fecha = date_create($row['fechaNacimientoNinio']);
                        echo date_format($fecha,"d/m/Y"); ?></td>
                        <td>
                            <?php $comportamiento = $row['comportamientoNinio'];
                            if($comportamiento==true){
                                echo "Si";
                            }else{
                                echo "No";
                            }?>
                        </td>
                    </tr>
                <?php 
                    $num = $num + 1;} ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="regalos.php">Juguetes</a>
    </body>
</html>