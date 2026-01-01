# Redis Caching Setup

This guide explains how to set up and use Redis caching in the Laravel application.

## Overview

This part integrates Redis as a caching layer for API responses and database queries in the Laravel application.
The goal is to reduce database load and improve performance by serving cached data when available.

🚀 **Features**
- Caches API responses and database queries using Redis
- Reuses cached data if available instead of hitting the database
- Supports dynamic cache keys based on request parameters and filters
- Automatic cache invalidation on data updates
- Easy to integrate with existing controllers using CacheHelper
- Configurable TTL (Time To Live) for different data types
- Seamless integration with Docker for development and production

## Prerequisites

- Docker Desktop installed and running
- Docker Compose (included with Docker Desktop)

## Quick Start

### 1. Start Redis Container

```bash
docker-compose up -d redis
```

### 2. Verify Redis is Running

```bash
docker-compose ps
```

You should see the `laravel-redis` container running.

### 3. Test Redis Connection

```bash
docker exec -it laravel-redis redis-cli ping
```

Expected output: `PONG`

## Configuration

### Environment Variables

Make sure your `.env` file has the following Redis configuration:

```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1
```

### Laravel Configuration

After updating `.env`, clear and rebuild config cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

## Docker Commands

### Start Redis
```bash
docker-compose up -d redis
```

### Stop Redis
```bash
docker-compose stop redis
```

### Restart Redis
```bash
docker-compose restart redis
```

### View Redis Logs
```bash
docker-compose logs -f redis
```

### Stop and Remove Container
```bash
docker-compose down
```

### Stop and Remove Container with Volumes (deletes data)
```bash
docker-compose down -v
```

## Redis CLI Access

Access Redis command line interface:

```bash
docker exec -it laravel-redis redis-cli
```

### Useful Redis CLI Commands

```redis
# List all keys
KEYS *

# Get a specific key
GET laravel_cache:key_name

# Delete all keys (be careful!)
FLUSHALL

# Exit Redis CLI
exit
```

## Testing from Laravel

### Using Tinker

```bash
php artisan tinker
```

```php
// Set a cache value
Cache::put('test', 'Hello Redis!', 60);

// Get a cache value
Cache::get('test');

// Check if key exists
Cache::has('test');

// Delete a cache value
Cache::forget('test');

// Clear all cache
Cache::flush();
```

## Troubleshooting

### Docker Desktop Not Running

If you see errors about Docker connection:
- Make sure Docker Desktop is running
- Wait a few seconds for Docker to fully start
- Try restarting Docker Desktop

### Port Already in Use

If port 6379 is already in use:
- Check if Redis is already running: `docker ps`
- Change port in `docker-compose.yml` and `.env`:
  ```yaml
  ports:
    - "6380:6379"  # Use 6380 instead of 6379
  ```
  ```env
  REDIS_PORT=6380
  ```

### PHP Redis Extension Not Installed

Laravel can use Redis in two ways:
1. **php_redis extension** (recommended, faster)
2. **predis package** (pure PHP, no extension needed) - Already installed

The project uses **predis** by default, so no PHP extension is required.

## Future: Full Docker Setup

When converting the entire application to Docker:

1. The Redis service already exists in `docker-compose.yml`
2. Add Laravel service to the same `docker-compose.yml`
3. Update `REDIS_HOST` from `127.0.0.1` to `redis` (service name)
4. All services will be on the same `laravel-network`

Example future `docker-compose.yml`:
```yaml
services:
  redis:
    # Already configured
  
  laravel:
    build: .
    depends_on:
      - redis
    networks:
      - laravel-network
```

## Notes

- Redis data is persisted in a Docker volume (`redis-data`)
- The container automatically restarts unless stopped manually
- Health checks ensure Redis is running correctly
- Network `laravel-network` is set up for future services
