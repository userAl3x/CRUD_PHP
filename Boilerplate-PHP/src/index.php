<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos</title>
    <!-- 
    Vinculando el archivo CSS externo. 
    El parámetro ?v=2 fuerza al navegador a cargar la nueva versión del 
    CSS en lugar de usar la versión en caché 
    -->
    <link rel="stylesheet" href="estilos.css?v=7">
</head>
<body>
    <h1>Menú CRUD de Productos</h1>
    <!-- Formulario para crear productos -->
    <h2>Crear Producto</h2>
    <form action="server.php" method="post">
        <!-- Nombre del producto -->
        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <br>

        <!-- Precio del producto (con comillas 14,2)-->
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" required><br>
        <br>
        
        <!-- Cantidad del producto -->
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required><br>
        <br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" name="action" value="Crear">
    </form>

    
    <!-- Lista de productos -->
    <h2>Lista de Productos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Bloque PHP -->
            <?php
            require_once 'Database.php';
            use App\Database\Database;

            // Obtener la instancia de la base de datos usando el patrón Singleton
            $db = Database::getInstance();
            $conn = $db->getConnection();

            // Consultar los registros
            $sql = "SELECT * FROM productos";              //nombre de la tabla productos
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Iterar sobre los registros
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . number_format($row["precio"], 2) . " €</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";

                    // Botones de acciones Actualizar y Eliminar
                    echo "<td> 
                            <form action='server.php' method='get' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' name='action' value='Actualizar'>
                            </form>
                            <br>
                            <form action='server.php' method='post' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input type='submit' name='action' value='Eliminar'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay Producto registrados</td></tr>";
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </tbody>
    </table>
    
    <!-- Footer -->
    <footer>
        <p style="text-align: center;">&copy; 2025 CRUD Productos - Todos los derechos reservados</p>
    </footer>
</body>
</html>
