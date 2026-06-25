# Changelog

## v2.4.0 (2026-06-25)

### Security
- **Autenticación en admin**: Login con usuario/contraseña en `/admin/login`. Todas las rutas de admin protegidas con middleware `auth`.
- Usuario por defecto: `admin` / `admin123` (generado por seeder).
- Sesión con `remember_token`, logout con invalidación de sesión.

### Infrastructure
- Migración `0012_create_users_table`.
- `User` model (Authenticatable + HasFactory), `UserFactory`, `UserSeeder`.
- `config/auth.php` y `config/mail.php` publicados.

## v2.3.0 (2026-06-25)

### Features
- **Email del pasajero**: Nuevo campo `email` en tickets. Se solicita al comprar y se almacena en BD.
- **Envío de boletos por correo**: Mailable `TicketMail` con template HTML que incluye los QR de cada boleto. Se envía automáticamente tras la compra (falla silenciosamente si no hay SMTP configurado).
- **Compartir**: Botones de WhatsApp y correo electrónico en la vista de impresión, con texto predefinido con origen/destino/fecha/hora.
- **Validación de boletos (puerta)**: Nueva ruta `/validar` — el chofer ingresa un folio y ve el detalle del boleto, incluyendo si ya venció.
- **Cancelación/reembolso**: Admin: en la vista del viaje, cada boleto tiene un botón de cancelación. Confirma y libera el asiento.
- **Páginas de error personalizadas**: Templates Blade para 403, 404, 429 y 503 con diseño acorde al sitio.
- **Exportar lista de pasajeros**: Botón CSV en la vista del viaje que descarga folio, nombre, asiento, fecha y correo de cada pasajero.

### Infrastructure
- Nueva migración `0011_add_email_to_tickets_table`.
- Configuración de correo (`config/mail.php`, variables en `.env.example`).

## v2.2.0 (2026-06-25)

### Features
- **GA4 custom events**: Full funnel tracking across the user journey — `view_home`, `view_search_results`, `select_trip`, `view_seat_selection`, `purchase_completed`, `purchase_failed`, `view_tickets`. Each event carries contextual params (origin, destination, price, ticket count, amount, etc.).
- **Tracking helper**: Global `pushGA4Event()` JS function in layout.

### Infrastructure
- All tracking fires via existing GA4 tag (`G-VXV091C1HJ`). No new dependencies.

## v2.1.0 (2026-06-24)

### Features
- **Admin i18n**: Full localization of all admin views (dashboard, sidebar, drivers, buses, trips, cities, branding, cashier). ~200 translation keys across 4 locales.
- **Language switcher**: Added locale dropdown to admin navbar.
- **Seat layout**: Restructured bus view to horizontal layout (viewed from above) with 4 seats per column (2+aisle+2), full-width aisle with centered "PASILLO" text, left-to-right seat orientation with numbering from nose to tail.
- **Intermediate stops**: Migration `0009_create_trip_stops_table`, `TripStop` model, CRUD in trip form, searchable stops.
- **PWA**: Service worker, manifest.json, icons generated via GD.
- **Translations from DB**: `Translation` model, migration `0010`, seeder, `TranslationServiceProvider` overriding Laravel translator.
- **Translation UI**: CRUD integrated into Personalización page with grouped collapsible sections and import from PHP files.
- **Branding/Personalización**: Rewritten with two-column layout, real-time preview via JS, enabled languages config, default language setting, color pickers, image uploads.
- **Admin dashboard**: Revenue KPI cards, top routes table, last-7-days revenue, hourly ticket sales chart.
- **Cities admin**: Quick-add modal from trip creation form.
- **Cashier**: Corte de caja and arqueo with CSV export and print.

### Cleanup
- Removed legacy `Route` model, unused `routes` and `cities` migrations, 47+ legacy image files.
- Removed stale imports in controllers.

### Infrastructure
- Nginx config: fixed images location root to `/var/www/html/public`.
- Flag images created via GD (`es.png`, `en.jpg`, `de.jpg`, `fr.png`).

## v2.0.10 (2026-06-23)

- fix: seat validation (numeric not integer), layout aisle in middle
- docs: update Portainer deploy instructions
- fix: hide print-area on screen in corte de caja view

## v2.0.9 (2026-06-21)

- feat: Portainer/Traefik deployment stack
- fix: network config for DNS resolution between containers
- refactor: single image `ghcr.io/zegnhabi/at` for dev + production
- fix: entrypoint improvements, APP_KEY generation, DB wait loop
- feat: Google Analytics tag (G-VXV091C1HJ)

## v2.0.0 (2026-04-26)

- Initial v2 release — full migration from legacy PHP 5 + MySQL to Laravel 11 + PostgreSQL 16
- Complete rewrite: Eloquent ORM, migrations, Blade templates, Bootstrap 5
- QR code generation with simple-qrcode
- Multi-language: es, en, de, fr
- CI/CD with GitHub Actions → GHCR
