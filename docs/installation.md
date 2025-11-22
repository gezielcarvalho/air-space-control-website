# Installation Guide

## Prerequisites

Before installing the Air Space Control Website, ensure you have the following software installed:

### Required Software

-   **PHP:** >= 8.1
-   **Composer:** Latest version
-   **Node.js:** >= 16.x
-   **npm:** >= 8.x (comes with Node.js)
-   **MySQL:** >= 8.0 or MariaDB >= 10.3
-   **Git:** For cloning the repository

### Optional Software

-   **Docker & Docker Compose:** For containerized development
-   **Web Server:** Apache or Nginx (if not using Docker)

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/gezielcarvalho/air-space-control-website.git
cd air-space-control-website
```

### 2. Install PHP Dependencies

```bash
composer install
```

This will install all Laravel dependencies and packages defined in `composer.json`.

### 3. Environment Configuration

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file and update the following variables:

```env
APP_NAME="Air Space Control"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=air_space_control
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

This command generates a unique application encryption key.

### 5. Create Database

Create a new MySQL database for the application:

```sql
CREATE DATABASE air_space_control CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Make sure the database name matches the `DB_DATABASE` value in your `.env` file.

### 6. Run Database Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This command will:

-   Drop all existing tables (if any)
-   Create all database tables
-   Populate tables with seed data

### 7. Install Laravel Passport

```bash
php artisan passport:install --force
```

This sets up OAuth2 authentication for API access. Save the client ID and secret for future reference.

### 8. Generate API Documentation

```bash
php artisan l5-swagger:generate
```

This generates Swagger/OpenAPI documentation for the API endpoints.

### 9. Optimize Application

```bash
php artisan optimize
```

This command:

-   Clears and caches configuration
-   Clears and caches routes
-   Optimizes class loading

### 10. Install Frontend Dependencies

```bash
npm install
```

This installs all JavaScript dependencies including Vue.js, Vite, and Tailwind CSS.

### 11. Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 12. Start the Application

#### Option A: Using PHP Built-in Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

#### Option B: Using Docker

```bash
docker-compose up -d
```

The application will be available at `http://localhost`.

## Post-Installation

### Verify Installation

1. Access the application in your browser
2. Check the API documentation at `/api/documentation`
3. Test the authentication system

### Default Credentials

If seeders created default users, check `database/seeders/DatabaseSeeder.php` for default credentials.

### Storage Permissions

Ensure the storage and bootstrap/cache directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```

On Linux/Mac, you may need to set proper ownership:

```bash
chown -R www-data:www-data storage bootstrap/cache
```

## Troubleshooting

### Common Issues

**Issue:** Database connection error

-   **Solution:** Verify database credentials in `.env` file
-   Ensure MySQL service is running

**Issue:** Composer install fails

-   **Solution:** Check PHP version (`php -v`)
-   Ensure all required PHP extensions are installed

**Issue:** npm install fails

-   **Solution:** Check Node.js version (`node -v`)
-   Clear npm cache: `npm cache clean --force`

**Issue:** Permission denied errors

-   **Solution:** Fix storage permissions (see Storage Permissions above)

**Issue:** Passport keys not found

-   **Solution:** Re-run `php artisan passport:install --force`

### Getting Help

-   Check the [GitHub Issues](https://github.com/gezielcarvalho/air-space-control-website/issues)
-   Review Laravel documentation: https://laravel.com/docs
-   Review Vue.js documentation: https://vuejs.org/

## Next Steps

After successful installation:

1. Review the [Architecture Documentation](architecture.md)
2. Explore the [API Documentation](api.md)
3. Check the [Deployment Guide](deployment.md) for production setup
