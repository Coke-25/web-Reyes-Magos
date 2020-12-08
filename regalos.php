<?php
    require_once("conexionBD.php");
    $conexion = new Conectar();
    //Se extraen todos los juguetes ordenando por el precio de mayor a menor
    $query = $conexion->selectAll("juguetes","precioJuguete desc");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Juguetes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    </head>
    <body>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre del juguete</th>
                    <th scope="col">Precio (€)</th>
                    <th scope="col">Rey encargado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Número de las filas
                $num=1;
                //Transformamos en array asociativo y mostramos los resultados
                while($row = $query->fetch_assoc()){ ?>
                    <tr>
                        <th scope="row"><?php echo $num ?></th>
                        <td><?php echo $row['nombreJuguete']; ?></td>
                        <td><?php echo $row['precioJuguete']; ?></td>
                        <td><?php $idRey = $row['idReyFK'];
                        $rey = $conexion->select("reyes",$idRey);
                        echo $rey['nombreRey'];?></td>
                    </tr>
                <?php 
                    $num = $num + 1;} ?>
            </tbody>
        </table>
        <!-- Botones para navegar entre páginass -->
        <a class="btn btn-success" href="ninos.php">Niños</a>
        <a class="btn btn-success" href="busqueda.php">Búsqueda</a>
    </body>
</html>