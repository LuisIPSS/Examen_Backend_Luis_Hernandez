# Rama
.
├── nginx //Configuración del servidor web que recibe las peticiones
├── php //Configuración del entorno de PHP
├── .env //Variables de entorno
├── docker-compose.yml //Define y levanta toda la infraestructura en Docker
└── TodoCamisetas //Proyecto
  ├── app
  │ ├── Http
  │ │ └── Controllers //Controladores del proyecto, reciben las peticiones (requests), ejecutan la lógica y devuelven una respuesta.
  │ │ ├── AdministracionController.php
  │ │ ├── CamisetasController.php
  │ │ ├── CamisetaTallasController.php
  │ │ ├── ClientesController.php
  │ │ ├── Controller.php
  │ │ ├── HealthController.php
  │ │ ├── TallasController.php
  │ │ ├── VentasController.php
  │ │ ├── VentasDetallesController.php
  │ │ └── Schemas //Estructura de los datos y como se esperan recibir los datos.
  │ │ │ ├── CamisetasSchemas.php
  │ │ │ ├── CamisetaTallaSchemas.php
  │ │ │ ├── ClientesShemas.php
  │ │ │ ├── TallasShemas.php
  │ │ │ ├── VentasDetallesShemas.php
  │ │ │ └── VentasShemas.php
  │ ├── Models // Representa las tablas de la base de datos
  │ │ ├── Camisetas.php
  │ │ ├── Camiseta_tallas.php
  │ │ ├── Clientes.php
  │ │ ├── Tallas.php
  │ │ ├── User.php
  │ │ ├── Ventas.php
  │ │ └── Ventas_detalles.php
  │ ├── Providers
  │ └── Traits
  │   └── ApiResponse.php //Cómo responde los controladores
  │
  ├── bootstrap
  │ └── app.php // Punto de arranque de la aplicación
  │
  ├── database
  │ ├── factories
  │ ├── migrations // Define y controla la estructura de la base de datos.
  │ │ ├── 0001_01_01_000000_create_users_table.php
  │ │ ├── 0001_01_01_000001_create_cache_table.php
  │ │ ├── 0001_01_01_000002_create_jobs_table.php
  │ │ ├── 2026_06_04_174302_create_personal_access_tokens_table.php
  │ │ ├── 2026_06_10_182400_create_clientes_table.php
  │ │ ├── 2026_06_10_182410_create_camisetas_table.php
  │ │ ├── 2026_06_10_182420_create_tallas_table.php
  │ │ ├── 2026_06_10_182430_create_camiseta_tallas_table.php
  │ │ ├── 2026_06_10_182440_create_ventas_table.php
  │ │ └── 2026_06_10_182450_create_ventas_detalles_table.php
  │ └── seeders
  │
  ├── resources
  │ ├── css
  │ ├── js
  │ └── views
  │
  ├── routes
  │ └── api.php //Se define los endpoints que puede consumir.
  │
  └── storage
  └── api-docs //Guardar la documentación generada de la API.

# Swagger 
http://localhost/api/documentation

# Coleccion de Postman
Se creo un Collection workflow donde el flujo es Crear todo (POST), Se obtienen los datos (GET/GET{id}), Se editan los datos (PUT), se verifica los endpoints del negocio (POST/calcularpreciofinal) y (GET/{id}/camisetas) para finalizar eliminando datos (DELETE).
Se realizo la collecion de esa manera para no se rompa el workflow en Postman.

# Repositorio GitHub

https://github.com/LuisHC32/Examen_Backend_Luis_Hernandez