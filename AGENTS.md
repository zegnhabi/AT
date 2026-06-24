# AGENTS.md

Laravel 11 bus ticketing app (PHP 8.2, PostgreSQL 16). Spanish-primary, 4 locales (es/en/de/fr).

## Commands

### Test

```bash
# Tests use SQLite (configured in phpunit.xml), not PostgreSQL
php artisan migrate --force          # must run first; creates database/database.sqlite
php vendor/bin/phpunit               # runs Unit + Feature suites
```

CI runs: `composer install` → `touch database/database.sqlite` → `php artisan migrate --force` → `phpunit`.

No lint, typecheck, or formatter is configured. There is no `pint`, `phpstan`, or `.editorconfig`.

### Dev server

```bash
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8080
```

Or with containers: `podman-compose up -d` (or `docker-compose up -d`), then `podman exec bus_ticketing_app php artisan migrate --seed`.

### Reset (destructive)

```bash
podman-compose down -v && podman-compose up -d
podman exec bus_ticketing_app php artisan migrate --seed
```

## Architecture

- **Public routes**: `routes/web.php` — homepage, search, seat selection, purchase, ticket printing, locale switch.
- **Admin routes**: `routes/admin.php` — `/admin/*` prefix. No authentication middleware. Manages drivers, buses, cities, trips, cashier (corte/arqueo), branding.
- **Route loading**: `bootstrap/app.php` loads web routes, then wraps admin routes in `web` middleware group.
- **Middleware**: `SetLocale` appended to web stack globally — reads `?lang=` param, stores in session, defaults to `es`.
- **Models**: Trip → belongsTo Bus, hasMany Ticket. Bus → belongsTo Driver, hasMany Trip. `Bus.seatsPerDeck()` divides seat_count by decks.
- **QR**: `simple-qrcode` package, SVG format, base64-inlined in ticket view.
- **Timezone**: `America/Monterrey` (hardcoded in `config/app.php`).

## Testing gotchas

- `phpunit.xml` sets `DB_CONNECTION=sqlite` with `DB_DATABASE=database/database.sqlite` — tests never hit PostgreSQL.
- `APP_KEY` is hardcoded in `phpunit.xml` for test env.
- Unit tests dir (`tests/Unit/`) is empty (`.gitkeep` only). All tests are Feature tests.
- Some tests hit admin routes (`/admin/*`) which have no auth — keep that in mind if adding auth later.
- `per_page=all` with 0 results previously caused DivisionByZeroError — verify edge cases if paginating.

## Migrations

Numbered with `0001_`–`0008_` prefix (non-standard Laravel naming). SQLite compatibility required for tests — watch for PostgreSQL-only functions (CI fixed `EXTRACT` → `strftime`).

## Deployment

- **Production image**: `ghcr.io/zegnhabi/at:latest` — single container with nginx + php-fpm + supervisor.
- **Entrypoint** (`docker/entrypoint-prod.sh`): copies env vars to `.env`, composer install, artisan key/migrate/cache, then supervisord.
- **Portainer deploy**: `docker-compose.portainer.yml` with Traefik labels for `at.mvps.com.mx`. Requires `traefik_public` external network.
- **CI**: `.github/workflows/deploy-ghcr.yml` — test → build → push to GHCR on `main` push.

## Localization

- Language files: `resources/lang/{es,en,de,fr}/messages.php`
- Default locale: `es`. Fallback: `es`. Faker locale: `es_MX`.
- Locale switcher: `GET /lang/{lang}` stores in session via `SetLocale` middleware.
