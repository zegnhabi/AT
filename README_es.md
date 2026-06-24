# Sistema de Boletaje para Autobuses

Sistema web para la venta de boletos de autobuses. Buscar corridas, seleccionar asientos, registrar pasajeros e imprimir boletos con código QR.

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

## Stack

| Componente     | v2 (moderno)                        |
|----------------|--------------------------------------|
| Backend        | Laravel 11 (PHP 8.2)                 |
| Base de datos  | PostgreSQL 16                        |
| ORM            | Eloquent + Migraciones               |
| Frontend       | HTML5 + Bootstrap 5.3                |
| QR             | simple-qrcode (base64)               |
| i18n           | Laravel Translation                  |
| Contenedor     | Podman / Docker Compose              |

---

## Levantar

```bash
podman-compose up -d
podman exec bus_ticketing_app php artisan migrate --seed
# http://localhost:8080
```

## Desarrollo local

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=8080
```
