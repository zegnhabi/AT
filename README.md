# Bus Ticketing System

Sistema web para la venta de boletos de autobuses. Permite buscar corridas por origen/destino/fecha, seleccionar asientos en un mapa visual, registrar pasajeros e imprimir boletos con código QR.

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=flat&logo=postgresql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-24-2496ED?style=flat&logo=docker&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-1.25-009639?style=flat&logo=nginx&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-3.7-0769AD?style=flat&logo=jquery&logoColor=white)
![GitHub](https://img.shields.io/badge/License-MIT-green?style=flat)

</div>

> Ver historial completo de cambios en [CHANGELOG.md](CHANGELOG.md)

---

## Stack Tecnológico

| Componente     | v1 (legacy)              | v2 (moderno)                        |
|----------------|--------------------------|-------------------------------------|
| **Backend**    | PHP 5 + mysqli           | Laravel 11 (PHP 8.2)                |
| **Base datos** | MySQL + MyISAM           | PostgreSQL 16                       |
| **ORM**        | SQL manual               | Eloquent ORM + Migraciones          |
| **Frontend**   | XHTML 1.0 + Bootstrap 2  | HTML5 + Bootstrap 5.3               |
| **QR**         | phpqrcode (archivo PNG)  | simple-qrcode (base64 inline)       |
| **i18n**       | `include()` condicional  | Laravel Translation + JSON          |
| **Contenedor** | —                        | Podman / Docker Compose             |
| **Servidor**   | Apache / Heroku           | Nginx + PHP-FPM                     |

---

## Requisitos

- PHP 8.2+
- Composer 2.x
- PostgreSQL 16
- Podman o Docker (opcional, para contenedores)
- Extensión PHP: `gd`, `pdo_pgsql`

---

## Instalación

### Con Podman / Docker (recomendado)

```bash
# 1. Clonar el repositorio
git clone <repo-url> AT
cd AT

# 2. Iniciar servicios (app + nginx + postgres)
podman-compose up -d

# 3. Ejecutar migraciones y sembrar datos demo
podman exec bus_ticketing_app php artisan migrate --seed

# 4. Abrir en navegador
xdg-open http://localhost:8080
```

### Desarrollo local

```bash
cp .env.example .env
# Editar .env con credenciales de PostgreSQL

composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8080
```

### Comandos útiles (Podman)

```bash
# Logs
podman-compose logs -f app

# Detener todo
podman-compose down

# Reset completo (borra volúmenes de datos)
podman-compose down -v && podman-compose up -d
podman exec bus_ticketing_app php artisan migrate --seed

# Acceder al contenedor
podman exec -it bus_ticketing_app bash
```

---

## Rutas

| Método | URI                    | Controlador                | Descripción                     |
|--------|------------------------|----------------------------|---------------------------------|
| GET    | `/`                    | `HomeController@index`     | Página principal                |
| GET    | `/buscar`              | `HomeController@search`    | Resultados de búsqueda          |
| GET    | `/elegir/{id}`         | `SeatController@select`    | Mapa de asientos                |
| POST   | `/comprar`             | `SeatController@purchase`  | Procesar compra                 |
| GET    | `/imprimir`            | `TicketController@print`   | Boletos + QR                    |
| GET    | `/lang/{es\|en\|de\|fr}` | `LocaleController@switch` | Cambiar idioma                  |

---

## Estructura del Proyecto

```
AT/
├── app/
│   ├── Console/Kernel.php
│   ├── Exceptions/Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── LocaleController.php
│   │   │   ├── SeatController.php
│   │   │   └── TicketController.php
│   │   ├── Kernel.php
│   │   └── Middleware/SetLocale.php
│   ├── Models/
│   │   ├── Bus.php
│   │   ├── Driver.php
│   │   ├── Route.php
│   │   ├── Ticket.php
│   │   └── Trip.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php
├── config/
│   ├── app.php
│   ├── database.php
│   ├── filesystems.php
│   ├── session.php
│   └── view.php
├── database/
│   ├── migrations/
│   │   ├── 0001_create_buses_table.php
│   │   ├── 0002_create_drivers_table.php
│   │   ├── 0003_create_routes_table.php
│   │   ├── 0004_create_trips_table.php
│   │   └── 0005_create_tickets_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── DriverSeeder.php
│       ├── BusSeeder.php
│       └── TripSeeder.php
├── docker/
│   └── nginx.conf
├── docker-compose.yml
├── Dockerfile
├── images/                      # Assets gráficos (compartidos con legacy)
├── Legacy/                      # Código original PHP 5 + MySQL
├── public/
│   ├── .htaccess
│   └── index.php                # Front controller Laravel
├── resources/
│   ├── lang/
│   │   ├── de/messages.php
│   │   ├── en/messages.php
│   │   ├── es/messages.php
│   │   └── fr/messages.php
│   └── views/
│       ├── home.blade.php
│       ├── search.blade.php
│       ├── seats.blade.php
│       ├── tickets.blade.php
│       └── layouts/app.blade.php
├── routes/
│   └── web.php
├── storage/                     # Logs, cache, sesiones, vistas compiladas
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── Dockerfile
├── docker-compose.yml
├── README.md
└── README_es.md
```

---

## Licencia

MIT — Jose Ibanez ([zegnhabi@gmail.com](mailto:zegnhabi@gmail.com))
