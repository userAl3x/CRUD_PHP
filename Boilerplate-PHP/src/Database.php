<?php

namespace App\Database;

use mysqli;

class Database {
    private static $instance = null;
    private $conn;
    private $host = 'db';                    // servidor phpmyadmin
    private $user = 'root';                  // usuario phpmyadmin
    private $pass = 'rootpassword';          // contraseña phpmyadmin
    private $name = 'productos_bbdd';        // nombre de la base de datos

    // Correct constructor declaration with two underscores
    private function __construct() {
        // Primero conectar sin especificar base de datos
        $this->conn = new mysqli($this->host, $this->user, $this->pass);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }

        // Crear base de datos si no existe
        $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS " . $this->name;
        if (!$this->conn->query($sqlCreateDB)) {
            die("Error creando base de datos: " . $this->conn->error);
        }

        // Seleccionar la base de datos
        $this->conn->select_db($this->name);

        // Crear tabla productos si no existe
        $this->createProductsTable();
    }

    // Método privado para crear la tabla productos
    private function createProductsTable() {
        $sqlCreateTable = "CREATE TABLE IF NOT EXISTS productos (
            id INT(6) AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            precio DECIMAL(10, 2) NOT NULL,
            cantidad INT NOT NULL
        )";
        
        if (!$this->conn->query($sqlCreateTable)) {
            die("Error creando tabla: " . $this->conn->error);
        }
    }

    // getInstance method should be static and correctly manage singleton instance creation
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Method to get the connection
    public function getConnection() {
        return $this->conn;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserialization of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}