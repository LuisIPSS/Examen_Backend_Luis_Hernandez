# Rama
.
├── nginx
├── php
├── .env
├── docker-compose.yml
└── TodoCamisetas
├── app
│ ├── Http
│ │ └── Controllers
│ │ ├── AdministracionController.php
│ │ ├── CamisetasController.php
│ │ ├── CamisetaTallasController.php
│ │ ├── ClientesController.php
│ │ ├── Controller.php
│ │ ├── HealthController.php
│ │ ├── TallasController.php
│ │ ├── VentasController.php
│ │ ├── VentasDetallesController.php
│ │ └── Schemas
│ │ ├── CamisetasSchemas.php
│ │ ├── CamisetaTallaSchemas.php
│ │ ├── ClientesShemas.php
│ │ ├── TallasShemas.php
│ │ ├── VentasDetallesShemas.php
│ │ └── VentasShemas.php
│ ├── Models
│ │ ├── Camisetas.php
│ │ ├── Camiseta_tallas.php
│ │ ├── Clientes.php
│ │ ├── Tallas.php
│ │ ├── User.php
│ │ ├── Ventas.php
│ │ └── Ventas_detalles.php
│ ├── Providers
│ └── Traits
│ └── ApiResponse.php
│
├── bootstrap
│ └── app.php
│
├── database
│ ├── factories
│ ├── migrations
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
│ └── api.php
│
└── storage
└── api-docs

# Swagger 
http://localhost/api/documentation

# Coleccion de Postman
Se creo un Collection workflow donde el flujo es Crear todo (POST), Se obtienen los datos (GET/GET{id}), Se editan los datos (PUT), se verifica los endpoints del negocio (POST/calcularpreciofinal) y (GET/{id}/camisetas) para finalizar eliminando datos (DELETE).
Se realizo la collecion de esa manera para no se rompa el workflow en Postman.

# Repositorio GitHub

https://github.com/LuisHC32/Examen_Backend_Luis_Hernandez