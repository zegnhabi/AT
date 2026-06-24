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

## Changelog

### [2.0.6] — 2026-06-23 — Testing, paginación unificada e impresión de pasajeros

- **Suite de tests PHPUnit 11**: 16 tests Feature cubriendo homepage, búsquedas, rutas admin, paginación, asientos
- **CI/CD con tests**: Job `test` ejecuta PHPUnit antes del build Docker; `build-and-push` solo corre si pasan
- **Impresión de pasajeros**: Botón "Imprimir" en detalle de viaje con vista optimizada para papel
- **Paginación unificada**: Dropdown "Mostrar" integrado en el paginador de todas las vistas admin
- **Paginador siempre visible**: Se muestra incluso con "Todos" seleccionados
- **Flechas tamaño uniforme**: `<` y `>` del mismo tamaño que los números de página
- **Default 5 items**: Todos los controllers usan 5 como valor por defecto
- Ver detalle completo en `README.md`

### [2.0.5] — 2026-06-23 — Layout asientos, paginación y deploy

- **Mapa de asientos horizontal**: Vista de izquierda a derecha (frente → trasera del bus) con layout 2+2 y pasillo
- **Bus CSS puro**: Reemplazadas imágenes tiny por diseño CSS con nariz, parabrisas, ventanas, pasillo y luces
- **Asientos CSS**: Cajas con números, hover, transiciones y check badge
- **Look moderno**: Gradient header, trip bar, leyenda con pills, botones con gradiente
- **Paginación admin**: Flechas con iconos Bootstrap, ventana de páginas con `…`, selector de items por página (5/10/25/50/Todos)
- **Deploy GHCR**: Workflow para build y push automático a GitHub Container Registry
- **Docker**: Entrypoint con `composer install` y generación automática de `APP_KEY`
- Ver detalle completo en `README.md`

### [2.0.4] — 2026-05-18 — Personalización de marca blanca

- Nueva sección `/admin/marca` para personalizar colores, logo, favicon, nombre y eslogan
- 5 selectores de color con vista previa en vivo
- Subida de logo y favicon con botón de restaurar
- Colores aplicados como CSS variables en frontend y admin
- Ver detalle completo en `README.md`

### [2.0.3] — 2026-05-18 — Backoffice administrativo

- Nuevo panel `/admin/` con dashboard, CRUD de choferes/autobuses/ciudades/viajes, corte de caja y arqueo
- Navbar propia con enlace al frontend, footer del frontend con enlace al admin
- Ver detalle completo en `README.md`

### [2.0.2] — 2026-05-18 — Datepicker, layout asientos y QR

- **Datepicker**: Campo de texto reemplazado por `<input type="date">` nativo HTML5 con validación de fecha futura
- **Layout asientos**: Imágenes fijadas a 35×24px para alineación uniforme en todas las filas
- **QR**: Cambiado de PNG (requería Imagick) a SVG (sin dependencias extra)
- Ver detalle completo en `README.md`

### [2.0.1] — 2026-05-18 — Correcciones post-lanzamiento

- **Date picker**: Se eliminó el bucle infinito de alerts (readonly + prompt → campo editable directo)
- **Búsqueda hoy**: El `TripSeeder` ahora incluye viajes desde el día actual
- **Horarios**: Agregados 6 horarios distribuidos (mañana, tarde, noche) para evitar filtrado total
- **Mensajes**: "Ha Sucedido Una Excepción" reemplazado por "No hay corridas disponibles"
- **Permisos**: `storage/` ahora es propiedad de `www-data` en la imagen Docker
- **Assets**: Nginx configurado con `location /images/` para servir correctamente las imágenes
- **Migraciones**: Orden corregido (drivers antes que buses)
- Ver detalle completo en `README.md`

### [2.0.0] — 2026-05-18 — Modernización completa

### [1.0.0] — 2009 — Versión original

- PHP 5 + MySQL + JavaScript
- Ubicado en `Legacy/`

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
