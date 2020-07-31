<?php
include './service/clienteService.php';


$connection = new Connection();
$conex = $connection->getConnection();

$where = "";
$cedula = "";
$nombre = "";
$fechaNacimiento = "";
$accion = "Agregar";
$codCliente = "";
$clienteService = new ClienteService();
$result = $clienteService->findAll();



if (isset($_POST["accion"]) && ($_POST["accion"] == "Agregar")) {
    $clienteService->insert($_POST["cedula"], $_POST["nombre"], $_POST["fechaNacimiento"]);
} else if (isset($_POST["accion"]) && ($_POST["accion"] == "Modificar")) {
    $clienteService->update($_POST["cedula"], $_POST["nombre"], $_POST["fechaNacimiento"], $_POST["codCliente"]);
} else if (isset($_GET["update"])) {
    $cliente = $clienteService->findByPK($_GET["update"]);
    if ($cliente != NULL) {
        $codCliente = $cliente["cod_cliente"];
        $cedula = $cliente["cedula"];
        $nombre = $cliente["nombre"];
        $fechaNacimiento = $cliente["fecha_nacimiento"];
        $accion = "Modificar";
    }
} else if (isset($_POST["eliCodigo"])) {
    $clienteService->delete($_POST["eliCodigo"]);
} else if (isset($_POST['buscar'])) {

    if (isset($_POST['xnombre'])) {
        $nombre = $_POST['xnombre'];
        $result = $conex->query("SELECT * FROM CLIENTE where nombre like '" . $nombre . "%'");
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>TALLER DE ACCESO A BASE DE DATOS CON PHP</title>
</head>

<body>

    <div style="text-align: center;">
        <h1>Conexion a Base de Datos MySQL</h1>

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
        if ($_SESSION['user']['ROL'] == 'ADM') {
            echo 'admin';
        } else {
            echo 'user';
        }
        ?>
        <a class="btn btn-info btn-block" href="logout.php">
            LOGOUT
        </a>



        <span><?php echo $_SESSION['user']['NAME'] ?></span>
        <h2>Ejemplo más cercano a la realidad</h2>
        <form method="post" action="index.php">
            <input type="text" placeholder="Nombre..." name="xnombre" />

            <button name="buscar" type="submit">Buscar</button>
        </form>
        <form id="forma" class="text-center border border-light p-5" action="index.php" style="font-family: arial"
            style="align-items:center; width:400px;" name="forma" method="post">
            <table border="1" class="table" style=" font-family: Arial; width:1000px" align="center">

                <thead class="" style="background-color:#17a2b8">
                    <tr>
                        <td colspan=4>&nbsp;</td>
                        <td><input type="button" name="eliminar" value="Eliminar" onclick="eliminarCliente();"></td>
                    </tr>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Fecha de nacimiento</th>
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
                        <td><a
                                href="index.php?update=<?php echo $row["cod_cliente"]; ?>"><?php echo $row["cod_cliente"]; ?></a>
                        </td>
                        <td><?php echo $row["cedula"]; ?> </td>
                        <td><?php echo $row["nombre"]; ?> </td>
                        <td><?php echo $row["fecha_nacimiento"]; ?> </td>
                        <td><input type="radio" name="eliCodigo" value=<?php echo $row["cod_cliente"]; ?>></td>
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

            <input type="hidden" name="codCliente" value="<?php echo $codCliente; ?>">

            <p class="h4 mb-4">Nuevo Producto</p>

            <!-- Cedula -->
            <input type="text" name="cedula" value="<?php echo $cedula; ?>" maxlength="10" size="11"
                class="form-control mb-4" id="lblCedula" required>

            <!-- Nombre -->
            <input type="text" name="nombre" value="<?php echo $nombre; ?>" maxlength="100" size="25"
                class="form-control mb-4" id="lblNombre" required>

            <!-- Fecha de nacimiento -->
            <input type="date" name="fechaNacimiento" value="<?php echo $fechaNacimiento; ?>" class="form-control mb-4"
                id="lblfechaNacimiento" required placeholder="<?php echo $fechaNacimiento; ?>">

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