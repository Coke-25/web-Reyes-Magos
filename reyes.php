<?php
    require_once("conexionBD.php");
    $conexion = new Conectar();
    //Lista con los niños que se han portado mal
    $listaNegra=[];
    $ninosMalos = $conexion->selectAll('ninios');
    while($filaNinosMalos = $ninosMalos->fetch_assoc()){
        if($filaNinosMalos['comportamientoNinio']==false){
            $listaNegra[]=$filaNinosMalos['nombreNinio'];
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Reyes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    </head>
    <body class="bg-dark">
        <div class="container p-5">
            <!-- Hacemos todo para cada rey -->
            <?php for($i=0;$i<3;$i++){
                $precioTotal=0;
                if($i==0){
                    $nombreRey = "Melchor";
                }else if($i==1){
                    $nombreRey = "Gaspar";
                }else{
                    $nombreRey = "Baltasar";
                }
                $juguetesRey = $conexion->selectAllKings($i+1);
                ?>
            <div class="row">
                <div class="col-9 mx-auto">
                    <h1 class="text-center text-white"><?php echo $nombreRey; ?></h1>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre del juguete</th>
                                <th scope="col">Niño</th>
                            </tr>
                        </thead>
                        <tbody class="bg-light">
                            <?php
                                $num=1;
                                //Sacamos todos los juguetes del rey correspondiente
                                while($filaRey = $juguetesRey->fetch_assoc()){
                                //Sacamos todos los juguetes del rey correspondiente que han sido pedidos
                                $nino = $conexion->selectAllFK($filaRey['idJuguete'],"idJugueteFK");
                                    /*Metemos un while dentro del anterior por si un juguete ha sido
                                    pedido por más de un niño*/
                                    while($filaNino = $nino->fetch_assoc()){
                                    //obtenemos los datos del niño
                                    $newNino = $conexion->select('ninios',$filaNino['idNinioFK']);
                                        //Solo se añaden si el niño se ha portado bien
                                        if($newNino['comportamientoNinio']==true){
                                            $precioTotal+=$filaRey['precioJuguete'];
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $num; ?></th>
                                            <td><?php echo $filaRey['nombreJuguete']; ?></td>
                                            <td><?php echo $newNino['nombreNinio']; ?></td>
                                        </tr>
                                        <?php $num+=1; }
                                    }
                                }
                                //Si estamos en la tabla de Gaspar (encargado de carbón)
                                if($i==1){
                                    //Añadimos los niños que se merecen carbón
                                    for($o=0;$o<count($listaNegra);$o++){?>
                                    <tr>
                                       <th scope="row"><?php echo $num; ?></th> 
                                       <td><?php echo "Carbón"; ?></td>
                                       <td><?php echo $listaNegra[$o]; ?></td>
                                    </tr>
                                    <?php $num+=1; }
                                }?>
                        </tbody>
                        <!-- Precio total de los juguetes de cada rey -->
                        <tfoot class="bg-light">
                            <tr>
                                <th scope="row">Precio total</th>
                                <td><?php echo $precioTotal."€"; ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php } ?>
            <a class="btn btn-success" href="busqueda.php">Búsqueda</a>
        </div>
    </body>
</html>