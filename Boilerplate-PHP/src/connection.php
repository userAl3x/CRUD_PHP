<?php
require_once 'Database.php';
use App\Database\Database;

// Obtener la instancia de la base de datos usando el patrón Singleton
$db = Database::getInstance();
$conn = $db->getConnection();

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Create database if it doesn't exist
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS productos_bbdd"; // bbdd products
if ($conn->query($sqlCreateDB) === TRUE) {
    echo "Database productos_bbdd created successfully<br>";
} else {
    echo "Error creating database: <br>" . $conn->error;
}

// Select the created or existing database
$conn->select_db("productos_bbdd");             //nombre de la base de datos productos_bbdd

// Create table if it doesn't exist productos
$sqlCreateRegistroTable = "CREATE TABLE IF NOT EXISTS productos (    
    id INT(6) AUTO_INCREMENT PRIMARY KEY,                 /*id autoincremental*/
    nombre VARCHAR(50) NOT NULL,                          /*nombre del producto*/
    precio DECIMAL(10, 2) NOT NULL,                       /*precio del producto*/
    cantidad INT NOT NULL                                 /*cantidad de productos*/
)";

if ($conn->query($sqlCreateRegistroTable) === TRUE) {
    echo "Table <Strong>productos</Strong> created successfully<br><br>";
} else {
    echo "Error creating table: <br>" . $conn->error;
}