# Docker Setup for Laravel Air Space Control Website

This Laravel application is fully dockerized with the following services:

## Services

-   **App (PHP-FPM 8.2)**: Laravel application
-   **Nginx**: Web server
-   **MySQL 8.0**: Database
-   **Redis**: Cache and session storage
-   **Mailpit**: Email testing (development)

## Prerequisites

-   Docker Desktop installed
-   Docker Compose installed

## Getting Started

### 1. Clone the repository (if not already done)

### 2. Copy the Docker environment file

```bash
cp .env.docker .env
```

### 3. Build and start the containers

```bash
docker-compose up -d --build
```

### 4. Install dependencies and setup application

```bash
# Access the app container
docker-compose exec app bash

# Inside the container, run:
composer install
php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan l5-swagger:generate

# Exit the container
exit
```

### 5. Access the application

-   **Application**: http://localhost:8080
-   **API Documentation**: http://localhost:8080/api/documentation
-   **Mailpit (Email Testing)**: http://localhost:8025

## Common Commands

### Start containers

```bash
docker-compose up -d
```

### Stop containers

```bash
docker-compose down
```

### View logs

```bash
docker-compose logs -f app
```

### Access app container shell

```bash
docker-compose exec app bash
```

### Run artisan commands

```bash
docker-compose exec app php artisan [command]
```

### Run composer commands

```bash
docker-compose exec app composer [command]
```

### Database migration

```bash
docker-compose exec app php artisan migrate
```

### Clear cache

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

## Port Mappings

-   **8080**: Nginx (web server)
-   **3307**: MySQL database
-   **6380**: Redis
-   **8025**: Mailpit web interface
-   **1025**: Mailpit SMTP

## Database Connection from Host

To connect to MySQL from your host machine:

-   Host: localhost
-   Port: 3307
-   Database: laravel
-   Username: laravel
-   Password: secret

## Volumes

-   Application files are mounted as volumes for hot-reloading during development
-   MySQL data is persisted in a Docker volume named `dbdata`

## Environment Variables

Edit the `.env` file to customize:

-   Database credentials
-   Application settings
-   Cache/Session drivers
-   Mail settings

## Troubleshooting

### Permission issues

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Rebuild containers

```bash
docker-compose down -v
docker-compose up -d --build
```

### View container status

```bash
docker-compose ps
```

## Production Deployment

For production, update the Dockerfile build target in docker-compose.yml:

```yaml
build:
    target: production
```

And update `.env`:

```
APP_ENV=production
APP_DEBUG=false
```
