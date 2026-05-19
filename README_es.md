# Sistema de Boletaje para Autobuses

Sistema web para la venta de boletos de autobuses. Buscar corridas, seleccionar asientos, registrar pasajeros e imprimir boletos con código QR.

---

## Changelog

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
