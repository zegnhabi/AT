# Deploy en Portainer

## Prerrequisitos

- Portainer CE/EE corriendo
- Redes `traefik_public` y `general_network` creadas en Portainer
- Traefik configurado con entrypoint `websecure` (HTTPS)

## Pasos

### 1. Generar APP_KEY

```bash
# Localmente o en el servidor
php artisan key:generate
# Copiar el valor generado (ej: base64:abc123...)
```

### 2. Crear el stack en Portainer

1. Ir a **Stacks** → **Add Stack**
2. Seleccionar **Repository** y apuntar a este repo
3. Compose file: `docker-compose.portainer.yml`
4. Agregar variables de entorno:

| Variable | Valor |
|----------|-------|
| `APP_KEY` | `base64:tu_key_aqui` |
| `DB_PASSWORD` | `contraseña_segura` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://at.mvps.com.mx` |

5. Click **Deploy the stack**

### 3. Verificar

```bash
# Verificar que los containers estén corriendo
docker ps | grep bus_ticketing

# Verificar logs
docker logs bus_ticketing_app

# Verificar que la app responde
curl -I https://at.mvps.com.mx
```

### 4. Migrar la base de datos

```bash
docker exec -it bus_ticketing_app php artisan migrate --force
docker exec -it bus_ticketing_app php artisan db:seed --force
```

## Variables de entorno

| Variable | Default | Descripción |
|----------|---------|-------------|
| `APP_KEY` | *(requerido)* | Clave de encriptación Laravel |
| `APP_ENV` | `production` | Entorno de la aplicación |
| `APP_DEBUG` | `false` | Modo debug (nunca true en producción) |
| `APP_URL` | `https://at.mvps.com.mx` | URL de la aplicación |
| `DB_DATABASE` | `bus_ticketing` | Nombre de la BD |
| `DB_USERNAME` | `busapp` | Usuario de la BD |
| `DB_PASSWORD` | *(requerido)* | Contraseña de la BD |
| `TZ` | `America/Monterrey` | Zona horaria |

## Estructura

```
at-app          → nginx + php-fpm (mismo contenedor, puerto 80)
at-db           → PostgreSQL 16
Traefik         → routing HTTPS → at-app:80
```

## Volumes persistentes

- `pg_data` → datos de PostgreSQL
- `app_storage` → archivos de Laravel (logs, cache, sesiones)
- `app_bootstrap` → cache de Laravel

## Comandos útiles

```bash
# Ver logs en tiempo real
docker logs -f bus_ticketing_app

# Entrar al contenedor
docker exec -it bus_ticketing_app bash

# Limpiar cache
docker exec bus_ticketing_app php artisan cache:clear
docker exec bus_ticketing_app php artisan config:clear
```
