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
| i18n           | Laravel Translation + DB (4 idiomas) |
| PWA            | Service Worker + Manifest            |
| Testing        | PHPUnit 11 (14 tests)                |
| CI/CD          | GitHub Actions → GHCR               |
| Contenedor     | Podman / Docker Compose              |

## Funcionalidades

### Público
- Búsqueda de corridas por origen, destino y fecha (incluye paradas intermedias)
- Selección de asientos en mapa visual (horizontal bus, 4 asientos por columna, 1-2 pisos)
- Compra de 1 a 5 boletos con nombre de pasajero
- Impresión de boletos con código QR
- PWA: instalable como app
- 4 idiomas: español, inglés, alemán, francés

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

## Testing

```bash
touch database/database.sqlite
php artisan migrate --force
php vendor/bin/phpunit
```

## Deploy en Portainer

```bash
cat DEPLOY_PORTAINER.md
```

1. Crear redes `traefik_public` y `general_network` en Portainer
2. Crear stack con `docker-compose.portainer.yml`
3. Setear `APP_KEY` y `DB_PASSWORD` como variables
4. Deploy
