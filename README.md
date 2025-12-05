# CRUD de Productos en PHP 🐘

Sistema CRUD (Create, Read, Update, Delete) completo para la gestión de productos, desarrollado en PHP con arquitectura moderna y buenas prácticas.

## 📋 Descripción

Aplicación web que permite gestionar un inventario de productos mediante operaciones CRUD. El sistema cuenta con una interfaz intuitiva y moderna, utilizando Docker para el entorno de desarrollo y MariaDB como base de datos.

## ✨ Características

- **CRUD Completo**: Crear, listar, actualizar y eliminar productos
- **Patrón Singleton**: Gestión eficiente de la conexión a base de datos
- **Diseño Moderno**: Interfaz responsive con CSS personalizado
- **Docker**: Entorno de desarrollo containerizado
- **Auto-configuración**: La base de datos y tablas se crean automáticamente
- **Validación de datos**: Formularios con validación HTML5
- **Prepared Statements**: Protección contra inyección SQL

## 🛠️ Tecnologías Utilizadas

- **PHP 8.x** - Lenguaje de programación backend
- **MariaDB** - Sistema de gestión de base de datos
- **Apache** - Servidor web
- **Docker & Docker Compose** - Containerización
- **phpMyAdmin** - Administración de base de datos
- **HTML5 & CSS3** - Frontend

## 📁 Estructura del Proyecto

```
CRUD_PHP/
└── Boilerplate-PHP/
    ├── docker-compose.yml      # Configuración de servicios Docker
    ├── Dockerfile              # Imagen personalizada de PHP
    ├── composer.json           # Dependencias de PHP
    ├── src/
    │   ├── index.php          # Página principal con formulario y listado
    │   ├── server.php         # Lógica de procesamiento CRUD
    │   ├── Database.php       # Clase Singleton para conexión DB
    │   ├── connection.php     # (Opcional) Configuración adicional
    │   └── estilos.css        # Estilos personalizados
    └── data/
        └── db/                # Datos persistentes de MariaDB
```

## 🚀 Instalación y Configuración

### Requisitos Previos

- Docker Desktop instalado ([Descargar aquí](https://www.docker.com/products/docker-desktop))
- Git instalado

### Pasos de Instalación

1. **Clonar el repositorio**

```bash
git clone https://github.com/tu-usuario/CRUD_PHP.git
cd CRUD_PHP/Boilerplate-PHP
```

2. **Crear archivo .env** (opcional)

Si necesitas personalizar puertos o credenciales, crea un archivo `.env`:

```env
WEB_HOST_PORT=8080
WEB_CONTAINER_PORT=80
DB_ROOT_PASSWORD=rootpassword
DB_NAME=productos_bbdd
DB_MANAGER_HOST_PORT=8081
DB_MANAGER_CONTAINER_PORT=80
```

3. **Levantar los contenedores**

```bash
docker-compose up -d
```

4. **Acceder a la aplicación**

- **Aplicación CRUD**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
  - Usuario: `root`
  - Contraseña: `rootpassword`

## 💾 Estructura de la Base de Datos

### Tabla: `productos`

| Campo    | Tipo          | Descripción              |
|----------|---------------|--------------------------|
| id       | INT(6)        | Clave primaria (AUTO_INCREMENT) |
| nombre   | VARCHAR(50)   | Nombre del producto      |
| precio   | DECIMAL(10,2) | Precio del producto      |
| cantidad | INT           | Cantidad en stock        |

La tabla se crea automáticamente al iniciar la aplicación.

## 🎯 Funcionalidades

### 1. Crear Producto
- Formulario con validación de campos
- Campos: Nombre, Precio (decimal), Cantidad (entero)
- Feedback visual tras la creación

### 2. Listar Productos
- Tabla responsive con todos los productos
- Muestra: ID, Nombre, Precio (formato moneda), Cantidad
- Botones de acción por cada producto

### 3. Actualizar Producto
- Formulario pre-rellenado con datos actuales
- Actualización en tiempo real
- Validación de datos

### 4. Eliminar Producto
- Eliminación directa desde la tabla
- Confirmación visual de la acción

## 🏗️ Arquitectura

### Patrón Singleton

La clase `Database` implementa el patrón Singleton para garantizar una única instancia de conexión:

```php
$db = Database::getInstance();
$conn = $db->getConnection();
```

### Seguridad

- **Prepared Statements**: Todas las consultas SQL utilizan declaraciones preparadas
- **Sanitización**: Uso de `htmlspecialchars()` para prevenir XSS
- **Validación**: Tipado estricto de variables (`(int)`)

## 🎨 Personalización

### Modificar Estilos

Edita el archivo `src/estilos.css` para personalizar:
- Colores (actualmente verde #4CAF50)
- Tipografía
- Espaciado y diseño

### Cambiar Base de Datos

Modifica las credenciales en `src/Database.php`:

```php
private $host = 'db';
private $user = 'root';
private $pass = 'rootpassword';
private $name = 'productos_bbdd';
```

## 🔧 Comandos Útiles

```bash
# Iniciar servicios
docker-compose up -d

# Detener servicios
docker-compose down

# Ver logs
docker-compose logs -f

# Reiniciar servicios
docker-compose restart

# Acceder al contenedor PHP
docker exec -it boilerplate-php-web-1 bash

# Instalar dependencias de Composer
docker exec -it boilerplate-php-web-1 composer install
```

## 📝 Notas de Desarrollo

- El parámetro `?v=2` en el CSS fuerza la recarga de estilos evitando problemas de caché
- Los datos se persisten en `./data/db/` incluso al detener los contenedores
- phpMyAdmin permite gestionar la base de datos visualmente

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👤 Autor

**Alex Jimenez**

## 🙏 Agradecimientos

- Basado en el Boilerplate-PHP para un desarrollo más eficiente
- Comunidad de PHP y Docker por las herramientas y documentación
