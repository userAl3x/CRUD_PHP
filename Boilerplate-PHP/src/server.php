<?php
require_once 'Database.php';
use App\Database\Database;

$tbname = "productos";                      //nombre de la tabla productos

// Obtener la instancia de la base de datos usando el patrón Singleton
$db = Database::getInstance();
$conn = $db->getConnection();

$action = $_POST['action'] ?? $_GET['action'] ?? ''; 

switch ($action) {
    //CRUD Crear
    case 'Crear':
        $stmt = $conn->prepare("INSERT INTO $tbname (nombre, precio, cantidad) VALUES (?, ?, ?)");
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $cantidad = (int) $_POST['cantidad'];
        $stmt->bind_param("ssi", $nombre, $precio, $cantidad);
        $stmt->execute();

        echo "Nuevo producto creado con éxito <br><br> <a href='index.php'>Volver</a>";
        $stmt->close();
        break;

    // CRUD Actualizar
    case 'Actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            
            //Una vez actualizados va aqui (Paso 2)
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $cantidad = (int) $_POST['cantidad'];
            
            $stmt = $conn->prepare("UPDATE $tbname SET nombre = ?, precio = ?, cantidad = ? WHERE id = ?");
            $stmt->bind_param("sdii", $nombre, $precio, $cantidad, $id);

            if ($stmt->execute()) {
                echo "Producto actualizado con éxito <br><br> <a href='index.php'>Volver</a>";
            } else {
                echo "Error al actualizar el Producto: " . $stmt->error;
            }
            $stmt->close();

        } else {
            //Al actualizar va primero a aqui (Paso 1)
            $id = (int) $_GET['id'];

            $stmt = $conn->prepare("SELECT * FROM $tbname WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                echo "<h2>Actualizar Producto</h2>";
                echo "<form action='server.php' method='post'>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($product['id']) . "'>";
                echo "<input type='hidden' name='action' value='Actualizar'>";

                echo "<label for='nombre'>Nombre:</label>";
                echo "<input type='text' id='nombre' name='nombre' value='" . htmlspecialchars($product['nombre']) . "' required><br>";
                echo "<br>";

                echo "<label for='precio'>Precio:</label>";
                echo "<input type='number' step='0.01' id='precio' name='precio' value='" . htmlspecialchars($product['precio']) . "' required><br>";
                echo "<br>";

                echo "<label for='cantidad'>Cantidad:</label>";
                echo "<input type='number' id='cantidad' name='cantidad' value='" . htmlspecialchars($product['cantidad']) . "' required><br>";
                echo "<br>";
                echo "<br>";

                echo "<button type='submit'>Guardar Cambios</button>";
                echo "</form>";
            } else {
                echo "Producto no encontrado. <br><br> <a href='index.php'>Volver</a>";
            }
            $stmt->close();
        }
        break;

    //CRUD Eliminar
    case 'Eliminar':
        $id = (int) $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM $tbname WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "Producto eliminado con éxito <br><br> <a href='index.php'>Volver</a>";
        $stmt->close();
        break;

    default:
        echo "Acción no válida <br><br> <a href='index.php'>Volver</a>";
}

$conn->close();