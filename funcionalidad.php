<?php
include './service/moduloService.php';

$connection = new Connection();
$conex = $connection->getConnection();


$where = "";
$nombre = "";
$estado = "";
$accion = "Agregar";
$codModulo = "";
$moduloService = new ModuloService();
$result = $moduloService->findAll();

if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $moduloService->insert($_POST["codModulo"], $_POST["nombre"], $_POST["estado"]);
} else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $moduloService->update($_POST["nombre"], $_POST["estado"], $_POST["codModulo"]);
} else if (isset($_GET["update"])) {
    $modulo = $moduloService->findByPK($_GET["update"]);
    if ($modulo != NULL) {
        $codModulo = $modulo["COD_MODULO"];
        $nombre = $modulo["NOMBRE"];
        $estado = $modulo["ESTADO"];
        $accion = "Modificar";
    }
} else if (isset($_POST["eliCodigo"])) {
    $moduloService->delete($_POST["eliCodigo"]);
} else if (isset($_POST['buscar'])) {

    if (isset($_POST['xnombre'])) {
        $nombre = $_POST['xnombre'];
        $result = $conex->query("SELECT * FROM SEG_MODULO where nombre like '" . $nombre . "%'");
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>TALLER DE ACCESO A BASE DE DATOS CON PHP</title>
</head>

<body>

    <div style="text-align: center;">
        <h1>Conexion a Base de Datos MySQL</h1>

        <!-- Default form contact -->

        <!-- Default form contact -->

        <?php


        if (!$conex) {
            echo "<p>Error: No se pudo conectar a MySQL." . PHP_EOL;
            echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
            echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
            echo "</p>";
            exit;
        }
        echo "<p> Conexión establecida a Base de Datos </p>";
        echo "<p>Información del host: " . mysqli_get_host_info($conex) . PHP_EOL . "</p>";
        ?>




        <br>
        <h2>GESTIÓN DE FUNCIONALIDADES</h2>
        <br>

        <div class="form-group row">
            <label for="empresa" class="col-md-1 control-label">MÓDULO:</label>
            
            <div class="col-md-3">
            <div>
       <button class="btn btn-info btn-block" type="submit" value="NUEVO" name="accion">
                ACEPTAR

            </button>
       </div>
                <select class="form-control input-sm" id="id_vendedor">
                    <?php

                    $sql_vendedor = mysqli_query($conex, "select * from SEG_MODULO") or die(mysqli_error($conex));;
                    while ($rw = mysqli_fetch_array($sql_vendedor)) {
                        $id_vendedor = $rw["COD_MODULO"];
                        $nombre_vendedor = $rw["NOMBRE"];

                    ?>
            </div>
            
            </div>
            <option value="<?php echo $id_vendedor ?>" <?php echo "SELECTED"; ?>><?php echo $nombre_vendedor ?></option>
        <?php
                    }
        ?>
       
        <br>
       
        <br>
        <br>
        <div>
            <br>
        <form method="post" action="funcionalidad.php">
            <input type="text" placeholder="Nombre..." name="xnombre" />
            <button name="buscar" type="submit">Buscar</button>
        </form>
        </div>
        
        <form id="forma" class="text-center border border-light p-5" action="funcionalidad.php" style="font-family: arial" style="align-items:center; width:400px;" name="forma" method="post">
            <table border="1" class="table" style=" font-family: Arial; width:1000px" align="center">

                <thead class="" style="background-color:#17a2b8">
                    <tr>
                        <td colspan=3 style="color: white;">FUNCIONALIDADES</td>

                    </tr>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">URL Principal</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <?php
                $contador = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($contador == 10) {
                            break;
                        }
                        $contador++;
                ?>
                        <tbody>
                            <tr>
                                <td><a href="funcionalidad.php?update=<?php echo $row["COD_MODULO"]; ?>"><?php echo $row["COD_MODULO"]; ?></a>
                                </td>
                                <td><?php echo $row["NOMBRE"]; ?> </td>
                                <td><?php echo $row["ESTADO"]; ?> </td>


                            </tr>
                        </tbody>
                    <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="5">No hay datos</td>
                    </tr>
                <?php } ?>

            </table>



            <!-- Default form contact -->


            <br>


            <!-- Send button -->
            <button class="btn btn-info btn-block" type="submit" value="NUEVO" name="accion">
                NUEVO

            </button>
            <button class="btn btn-info btn-block" type="submit" value="<?php echo $accion ?>" name="accion">
                MODIFICAR

            </button>
            <button class="btn btn-info btn-block" type="submit" value="<?php echo $accion ?>" name="accion">
                ELIMINAR

            </button>

        </form>
        <!-- Default form contact -->
        </div>
</body>
<script>
    function eliminarCliente() {
        document.getElementById('forma').submit();
    }
</script>

</html>