# Changelog

### [2.0.9] — 2026-06-23 — Módulo de idiomas, fix CI/CD

#### Nuevo: Configuración de idiomas en Personalización
- Selector de idioma predeterminado del sistema (es, en, de, fr)
- Selector de idiomas habilitados (checkboxes para activar/desactivar idiomas)
- Idioma predeterminado aplicado como locale inicial de la aplicación

#### Corregido: CI/CD
- `APP_KEY` agregado a `phpunit.xml` (resolvía `MissingAppKeyException`)
- Test de asientos simplificado para no depender de datos en BD

### [2.0.8] — 2026-06-23 — Asientos dinámicos y buses de 2 pisos

#### Nuevo: Sistema de asientos dinámico
- **Asientos según seat_count**: El mapa de asientos ahora se genera dinámicamente según el campo `seat_count` del autobús (ya no está hardcodeado a 36)
- **Soporte de 2 pisos**: Nuevo campo `decks` (1 o 2) en la tabla `buses`. Buses de 2 pisos muestran tabs "Piso 1" / "Piso 2" en la selección de asientos
- **Layout 2+2 adaptable**: Cada piso muestra filas de 4 asientos (2+2 con pasillo) que se adaptan al número de asientos por piso
- **Validación dinámica**: La validación de asientos ahora usa el `seat_count` real del autobús

#### Corregido
- **Full-bus check**: Ahora compara con `bus->seat_count` en vez de 36 fijo
- **/36 hardcodeado en admin viajes**: Reemplazado por `$t->bus->seat_count`

#### Migración
- `0008_add_decks_to_buses_table.php`: Campo `decks` (tinyInteger, default 1)

### [2.0.7] — 2026-06-23 — Export CSV, impresión corte/arqueo, changelog separado

#### Nuevo: Exportar a CSV
- **Corte de caja**: Botón "Exportar" genera CSV con folio, pasajero, ruta, fecha viaje, hora, asiento, monto + totales
- **Arqueo**: Botón "Exportar" genera CSV con folio, fecha venta, pasajero, ruta, fecha viaje, hora, asiento, monto + totales
- Rutas: `GET /admin/corte/exportar` y `GET /admin/arqueo/exportar`

#### Nuevo: Imprimir corte y arqueo
- Botón "Imprimir" en ambas páginas con vista optimizada para papel
- CSS `@media print` muestra KPIs, resumen por ruta (corte) y tabla detallada

#### Corregido: Dropdowns duplicados eliminados
- Removido dropdown "Mostrar" del header en Ciudades y Arqueo (ya estaba en el paginador)

#### Mantenimiento
- Changelog separado del README en `CHANGELOG.md`
- READMEs actualizados con enlace a CHANGELOG.md

### [2.0.6] — 2026-06-23 — Testing, paginación unificada e impresión de pasajeros

#### Nuevo: Suite de tests con PHPUnit 11
- **16 tests Feature** cubriendo: homepage, búsqueda, todas las rutas admin, paginación con per_page, asientos, locale switch
- `phpunit.xml` configurado con SQLite in-memory para tests rápidos
- Estructura `tests/Feature/` y `tests/Unit/` con TestCase base
- `autoload-dev` agregado en `composer.json` para namespace `Tests\`
- `composer.lock` agregado al repositorio (requerido por Dependabot)

#### Nuevo: CI/CD con stage de tests
- **Job `test`** ejecuta PHPUnit antes del build del Docker image
- **Job `build-and-push`** solo se ejecuta si los tests pasan (`needs: test`)
- Setup PHP 8.2 con extensiones necesarias (pgsql, gd, mbstring, zip)

#### Nuevo: Impresión de lista de pasajeros
- Botón "Imprimir" en el detalle de viaje (`/admin/viajes/:id`) visible solo cuando hay boletos vendidos
- Vista de impresión optimizada: tabla limpia con columna `#` correlativa, encabezado con ruta/fecha/autobús/chofer
- Pie de página con timestamp de impresión y total de pasajeros
- CSS `@media print` oculta el UI admin completo mostrando solo la tabla de pasajeros

#### Corregido: Paginación admin unificada
- **Selector de items por página en el paginador**: Dropdown "Mostrar 5/10/25/50/Todos" integrado dentro de la barra de paginación en todas las vistas admin (viajes, ciudades, autobuses, choferes, arqueo)
- **Paginador siempre visible**: El selector se muestra incluso cuando se selecciona "Todos" (sin páginas), permitiendo cambiar el tamaño de página en cualquier momento
- **Flechas del mismo tamaño**: Removida clase `pagination-sm` para que `<` y `>` tengan el mismo tamaño que los números de página
- **Default 5 items**: Todos los controllers ahora usan 5 como valor por defecto (era 15 en viajes)

#### Mejorado: Paginación con ventana dinámica
- Paginador muestra ~2 páginas alrededor de la actual con `…` para saltos
- Texto informativo: "Mostrar [dropdown] · Página **1** de **12**" o "Mostrar [dropdown] · **180** registro(s)" cuando todos se muestran
- Preserva filtros activos (fechas, ciudades) al cambiar tamaño de página

### [2.0.5] — 2026-06-23 — Layout asientos, paginación y deploy

#### Corregido: Layout de selección de asientos
- **Vista horizontal**: El mapa de asientos ahora se muestra de izquierda a derecha (frente → trasera del bus)
- **Layout 2+2 con pasillo**: Cada columna muestra 2 filas arriba del pasillo y 2 filas abajo
- **Bus CSS puro**: Reemplazadas las imágenes tiny `bus_top.gif` (57px) y `bus_back.gif` (21px) por un diseño CSS con nariz redondeada, parabrisas, ventanas, pasillo completo y luces traseras
- **Asientos CSS**: Cajas con números en vez de imágenes JPG diminutas, con hover, transiciones y check badge en selección
- **Look and feel moderno**: Gradient header, trip bar estilo roadmap, leyenda con pills, botones con gradiente y sombra

#### Corregido: Paginación admin
- **Flechas gigantes**: Reemplazada la paginación default de Laravel (Tailwind SVG) por vista custom Bootstrap con iconos `bi-chevron-left/right`
- **Ventana de páginas**: Paginador limitado a 2 páginas a cada lado con `…` para saltos (ej: `< 1 2 3 … 12 >`)
- **Selector de items por página**: Agregado dropdown en Ciudades y Viajes con opciones 5, 10, 25, 50 y "Todos"
- **Conteo corregido**: Ciudades ahora cuenta ciudades distintas (no filas de viajes)

#### Nuevo: Deploy a GHCR
- Workflow `.github/workflows/deploy-ghcr.yml` para build y push automático a GitHub Container Registry
- Trigger en push a `main` o manual (`workflow_dispatch`)
- Tags: `latest` + SHA del commit
- `.dockerignore` agregado para excluir archivos innecesarios del build context

#### Infraestructura
- `Dockerfile` simplificado: el `APP_KEY` y dependencias se generan en el entrypoint
- `docker/entrypoint.sh` creado: ejecuta `composer install`, genera `APP_KEY` si falta, y arranca `php-fpm`

### [2.0.4] — 2026-05-18 — Personalización de marca blanca

#### Nuevo: Sección de Marca (`/admin/marca`)
Panel de personalización visual completa de la aplicación sin tocar código:

**Información de empresa**
- Nombre de la empresa (se usa en título y alt de logo)
- Eslogan (se muestra bajo el logo en el frontend)

**Colores frontend** (3 selectores de color)
- Color primario: botones "Buscar", badges, fondo de tarjetas
- Color secundario: texto sobre fondo primario
- Color de acento: botones "Continuar", enlaces

**Colores panel admin** (2 selectores de color)
- Color primario admin: navbar, gradientes, botones
- Color acento admin: hover states, elementos activos

**Imágenes**
- Logo: subida por archivo (jpeg, png, gif, webp, max 2MB)
- Favicon: subida por archivo (ico, png, max 512KB)
- Botón "Restaurar" para volver al valor por defecto

**Vista previa en vivo**
- Panel lateral que muestra cómo se ven los colores configurados
- Simulación de botones, navbar admin y título con los valores actuales

#### Backend
- Migración `0007_create_settings_table.php` con 7 settings por defecto
- Modelo `Setting` con helpers `get()`, `set()`, `allAsArray()`
- Controlador `BrandingController` con validación de colores hex, subida de imágenes, restore
- `AppServiceProvider` carga settings y los comparte como `$brand` en todas las vistas

#### Frontend aplicado
- Layout usa `$brand['primary_color']`, `$brand['secondary_color']`, `$brand['accent_color']` como CSS variables
- Logo y favicon dinámicos desde `$brand['logo']` y `$brand['favicon']`
- Eslogan visible bajo el logo

#### Admin aplicado
- Navbar y botones usan `$brand['admin_primary_color']` y `$brand['admin_accent_color']`
- Favicon dinámico desde la configuración

### [2.0.3] — 2026-05-18 — Backoffice administrativo

#### Nuevo: Panel de Administración (`/admin/`)
Se agregó un backoffice completo bajo la ruta `/admin/` con navbar propia y enlace desde el footer del frontend.

**Dashboard** (`/admin/`)
- KPIs principales: viajes hoy, boletos vendidos, ingresos, % ocupación
- Autobuses registrados y choferes totales
- Top 5 rutas más populares del día
- Ingresos de los últimos 7 días
- Barras de boletos vendidos por hora (hoy)

**Choferes** (`/admin/drivers`)
- CRUD completo: listar, crear, editar, eliminar
- Campos: nombre, género, edad, teléfono
- Validaciones: nombre requerido, género M/F, edad 18-99

**Autobuses** (`/admin/buses`)
- CRUD completo: listar, crear, editar, eliminar
- Campos: asientos, año modelo, serie, chofer asignado (select)
- Al eliminar se borran los viajes asociados y se desasigna el chofer

**Ciudades** (`/admin/ciudades`)
- Listado de ciudades extraídas de los viajes registrados
- Cada ciudad enlaza a sus viajes asociados (como origen o destino)

**Viajes** (`/admin/viajes`)
- Listado con filtros por ciudad y fecha
- Vista detalle con información del viaje y tabla de pasajeros
- Eliminación de viajes con sus boletos

**Corte de caja** (`/admin/corte`)
- Consulta por fecha
- KPIs: boletos vendidos, ingreso total, ingreso ayer, ingreso últimos 7 días
- Resumen agrupado por ruta
- Detalle de ventas del día

**Arqueo** (`/admin/arqueo`)
- Consulta por rango de fechas (inicio-fin)
- KPIs: total boletos, ingreso, viajes con ventas, período
- Tabla detallada de todas las transacciones con paginación

### [2.0.2] — 2026-05-18 — Datepicker, layout asientos y QR

#### Bugs corregidos
- **Datepicker precario**: El campo de fecha era un `<input type="text">` sin ningún widget visual. Se reemplazó por `<input type="date">` nativo de HTML5 con validación `after_or_equal:today` en el controlador, y el formato aceptado cambió de `d-m-Y` a `Y-m-d` (estándar ISO 8601).
- **Layout de asientos descuadrado**: Las imágenes de asientos tenían tamaños inconsistentes (35×24px JPG vs 35×23px GIF), lo que desalineaba las filas del autobús. Se fijó `width:35px;height:24px` en todas las imágenes de asientos y se cambió el outline de selección a un borde sin desplazamiento.
- **QR requiere Imagick**: La librería `simple-qrcode` usaba el backend `png` que requiere la extensión PHP `imagick`, no instalada en el contenedor. Se cambió a `format('svg')` que no necesita extensiones adicionales, y la vista actualizó el MIME type a `image/svg+xml`.

### [2.0.1] — 2026-05-18 — Correcciones post-lanzamiento

#### Bugs corregidos
- **Date picker cíclico**: El campo de fecha usaba `readonly` + `prompt()` en los eventos `click` y `focus`, lo que provocaba un bucle infinito de alerts. Se reemplazó por un campo de texto editable directo sin validación por prompt.
- **Búsqueda sin resultados**: El `TripSeeder` generaba viajes a partir del día siguiente (`now()->addDay()`), por lo que buscar con la fecha actual siempre retornaba vacío. Se cambió a `now()->addDays(0)` para incluir el día actual.
- **Horarios limitados**: Solo existían 3 horarios matutinos (07:00, 07:30, 08:00). Al caer la tarde, el filtro `departure_time >= now()` eliminaba todos los resultados. Se agregaron 6 horarios distribuidos durante el día (07:00, 10:30, 14:00, 17:30, 20:00, 23:00).
- **Mensaje de error confuso**: Cuando no había corridas disponibles se mostraba "Ha Sucedido Una Excepción". Se cambió por un mensaje informativo claro ("No hay corridas disponibles para la fecha seleccionada") con estilo `alert-info`.
- **Permisos storage/**: El directorio `storage/` quedaba propiedad de `root` en la imagen Docker, causando error 500 al escribir logs desde FPM (`www-data`). Se agregó `chown` en el `Dockerfile` y durante el entrypoint.
- **APP_KEY inválida**: El `.env.example` contenía una `APP_KEY` de prueba inválida. Se documentó que debe ejecutarse `php artisan key:generate` en el primer inicio.
- **Assets 404**: La configuración de Nginx usaba `root /var/www/html/public` pero las imágenes están en `/var/www/html/images/`. Se agregó un `location /images/` con `alias` explícito.
- **Migraciones desordenadas**: La migración `buses` referenciaba `drivers` antes de que existiera la tabla. Se reordenaron los archivos con prefijo numérico correcto.

#### Mejoras
- El `TripSeeder` ahora genera más variedad de horarios (6 franjas vs 3 originales)
- Mensaje `no_trips` traducido a los 4 idiomas (es, en, de, fr)
- Se actualizó `Dockerfile` con permisos correctos para `www-data`

### [2.0.0] — 2026-05-18 — Modernización completa

#### Cambios estructurales
- Todo el código legacy se movió a `Legacy/` para referencia histórica
- Nueva arquitectura Laravel 11 en la raíz del proyecto
- Base de datos migrada de MySQL/MyISAM a PostgreSQL 16 con Eloquent ORM
- Frontend migrado de XHTML + Bootstrap 2 a HTML5 + Bootstrap 5
- Sistema de i18n migrado de `include()` PHP plano a archivos de localización Laravel

#### Infraestructura
- Se agregó `Dockerfile` con PHP 8.2 FPM + Composer
- Se agregó `docker-compose.yml` con 3 servicios: `app` (PHP-FPM), `nginx` (Alpine), `db` (PostgreSQL 16)
- Se agregó configuración Nginx en `docker/nginx.conf`
- Se agregó `.env.example` con configuración base
- Se agregó `.gitignore` para la nueva estructura

#### Modelo de datos (nuevo)
| Legacy (MySQL)     | Moderno (PostgreSQL) | Cambios                          |
|--------------------|----------------------|----------------------------------|
| `autobus`          | `buses`              | FK a `drivers`, timestamps       |
| `chofer`           | `drivers`            | PK auto-increment, timestamps    |
| `boleto` (viajes)  | `trips`              | FK a `buses`, nombres claros     |
| `boletos` (ventas) | `tickets`            | FK a `trips`, timestamps         |
| `corridas`         | `routes`             | Sin cambios funcionales          |

#### Backend
- Migraciones: 5 archivos con esquema limpio y foreign keys
- Seeders: datos demo (12 choferes, 5 autobuses, 180+ corridas)
- Controladores: `HomeController`, `SeatController`, `TicketController`, `LocaleController`
- Middleware: `SetLocale` para detección automática de idioma

#### Frontend
- `home.blade.php` — Página principal con selectores de origen/destino/fecha
- `search.blade.php` — Resultados de búsqueda con selección de corrida
- `seats.blade.php` — Mapa visual de asientos del autobús (36 asientos en 4 filas)
- `tickets.blade.php` — Impresión de boletos con código QR embebido en base64
- `layouts/app.blade.php` — Layout base con Bootstrap 5, manejo de errores, footer

#### Internacionalización
- 4 idiomas completos: Español (`es`), English (`en`), Deutsch (`de`), Français (`fr`)
- 46 claves traducidas por idioma en `resources/lang/{lang}/messages.php`
- Conmutación vía URL `/lang/{es|en|de|fr}` con persistencia en sesión

#### Funcionalidades conservadas
- [x] Búsqueda de corridas por origen, destino y fecha
- [x] Validación de fecha: no permite fechas pasadas
- [x] Mapa de asientos con 36 posiciones en 4 filas
- [x] Estado visual: disponible / ocupado / seleccionado
- [x] Compra de 1 a 5 boletos por transacción
- [x] Captura de nombre por pasajero
- [x] Generación de código QR con datos del viaje
- [x] Vista de impresión optimizada para navegador

### [1.0.0] — 2009 — Versión original (legacy)

- PHP 5 + MySQL + JavaScript (XHTML)
- Sistema de archivos plano sin framework
- Motor MyISAM en todas las tablas
- Consultas SQL embebidas en archivos PHP
- Código QR generado con librería `phpqrcode`
- Internacionalización por `include()` condicional
- Ubicado en `Legacy/` desde la versión 2.0.0
