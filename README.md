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
| **i18n**       | `include()` condicional  | Laravel Translation + JSON + DB     |
| **PWA**        | —                        | Service Worker + Manifest           |
| **Contenedor** | —                        | Podman / Docker Compose             |
| **Servidor**   | Apache / Heroku           | Nginx + PHP-FPM                     |
| **CI/CD**      | —                        | GitHub Actions → GHCR               |

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

### Testing

```bash
touch database/database.sqlite
php artisan migrate --force
php vendor/bin/phpunit
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

## Funcionalidades

### Público
- Búsqueda de corridas por origen, destino y fecha (incluye paradas intermedias)
- Selección de asientos en mapa visual (horizontal bus, 4 asientos por columna, 1-2 pisos)
- Compra de 1 a 5 boletos con nombre de pasajero
- Impresión de boletos con código QR
- PWA: instalable como app, funciona offline parcial
- 4 idiomas: español, inglés, alemán, francés
- **Analytics**: GA4 con eventos personalizados de funnel completo — búsqueda, selección de asientos, compras exitosas/fallidas

### Admin (`/admin/*`)
- Dashboard con KPIs (viajes/boletos/ingresos hoy, ocupación)
- CRUD completo: choferes, autobuses, ciudades, viajes
- Paradas intermedias por viaje
- Corte de caja diario y arqueo por fechas (exportar CSV, imprimir)
- Impresión de lista de pasajeros por viaje
- Personalización de marca: colores, logo, favicon, idiomas disponibles
- Traducciones gestionadas desde BD con import de archivos PHP
- Panel completamente localizado en 4 idiomas

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
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── LocaleController.php
│   │   │   ├── SeatController.php
│   │   │   ├── TicketController.php
│   │   │   └── Admin/
│   │   │       ├── BrandingController.php
│   │   │       ├── BusController.php
│   │   │       ├── CityController.php
│   │   │       ├── DashboardController.php
│   │   │       ├── DriverController.php
│   │   │       └── TripController.php
│   │   └── Middleware/SetLocale.php
│   ├── Models/
│   │   ├── Bus.php
│   │   ├── Driver.php
│   │   ├── Ticket.php
│   │   ├── Translation.php
│   │   ├── Trip.php
│   │   └── TripStop.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── TranslationServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 0001_create_buses_table.php
│   │   ├── 0002_create_drivers_table.php
│   │   ├── 0003_create_trips_table.php
│   │   ├── 0004_create_tickets_table.php
│   │   ├── 0005_create_settings_table.php
│   │   ├── 0006_create_trip_stops_table.php
│   │   └── 0007_create_translations_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── DriverSeeder.php
│       ├── BusSeeder.php
│       ├── TripSeeder.php
│       └── TranslationSeeder.php
├── docker/
│   ├── entrypoint-prod.sh
│   └── nginx.conf
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
│       └── admin/
│           ├── layouts/app.blade.php
│           ├── dashboard.blade.php
│           ├── drivers/
│           ├── buses/
│           ├── trips/
│           ├── cities/
│           ├── branding/index.blade.php
│           └── cashier/
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── console.php
├── public/
│   ├── manifest.json
│   ├── sw.js
│   └── images/
├── docker-compose.yml
├── Dockerfile
├── README.md
├── README_es.md
└── CHANGELOG.md
```

---

## Licencia

MIT — Jose Ibanez ([zegnhabi@gmail.com](mailto:zegnhabi@gmail.com))
