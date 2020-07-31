<?php
include './service/moduloService.php';

$connection = new Connection();
$conex = $connection->getConnection();

$where = "";
$nombre = "";
$estado= "";
$accion = "Agregar";
$codModulo = "";
$moduloService = new ModuloService();
$result = $moduloService->findAll();

if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $moduloService->insert($_POST["codModulo"],$_POST["nombre"], $_POST["estado"]);
} else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $moduloService->update($_POST["nombre"], $_POST["estado"],$_POST["codModulo"]);
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
        

        <!-- Default form contact -->

        <!-- Default form contact -->

        <?php
        $conex = mysqli_connect("127.0.0.1", "root", "admin123", "test1");

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
        <a class="btn btn-info btn-block" href="logout.php">
            LOGOUT
        </a>



<br>
        <h2>GESTIÓN DE MÓDULOS</h2>
        <form method="post" action="seg_modulo.php">
            <input type="text" placeholder="Nombre..." name="xnombre" />

            <button name="buscar" type="submit">Buscar</button>
        </form>
        <form id="forma" class="text-center border border-light p-5" action="seg_modulo.php" style="font-family: arial" style="align-items:center; width:400px;" name="forma" method="post">
            <table border="1" class="table" style=" font-family: Arial; width:1000px" align="center">

                <thead class="" style="background-color:#17a2b8">
                    <tr>
                        <td colspan=3>&nbsp;</td>
                        <td><input type="button" name="eliminar" value="Eliminar" onclick="eliminarCliente();"></td>
                    </tr>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">ELIMINAR</th>
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
                                <td><a href="seg_modulo.php?update=<?php echo $row["COD_MODULO"]; ?>"><?php echo $row["COD_MODULO"]; ?></a>
                                </td>
                                <td><?php echo $row["NOMBRE"]; ?> </td>
                                <td><?php echo $row["ESTADO"]; ?> </td>
                               
                                <td><input type="radio" name="eliCodigo" value=<?php echo $row["COD_MODULO"]; ?>></td>
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
            <p class="h4 mb-4">Nuevo Módulo</p>
            <input type="text" name="codModulo" value="<?php echo $codModulo; ?>"  maxlength="100" size="25" class="form-control mb-4" id="lblNombre" required placeholder="Código">
            <!-- Nombre -->
            <input type="text" name="nombre" value="<?php echo $nombre; ?>" maxlength="100" size="25" class="form-control mb-4" id="lblNombre" required placeholder="Nombre">

            <!-- Fecha de nacimiento -->
            <input type="text" name="estado" value="<?php echo $estado; ?>" class="form-control mb-4" id="lblfechaNacimiento" required placeholder="Estado">

            <!-- Send button -->
            <button class="btn btn-info btn-block" type="submit" value="<?php echo $accion ?>" name="accion">
                <?php echo $accion ?>

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