# Deployment Guide

## Overview

This guide covers deploying the Air Space Control Website to production environments. The application can be deployed using traditional hosting, containerized environments, or cloud platforms.

## Pre-Deployment Checklist

-   [ ] All tests passing
-   [ ] Environment variables configured
-   [ ] Database migrations tested
-   [ ] Frontend assets built for production
-   [ ] SSL certificate obtained
-   [ ] Backup strategy implemented
-   [ ] Monitoring tools configured
-   [ ] API documentation updated

## Deployment Options

### Option 1: Traditional VPS/Dedicated Server

#### Requirements

-   Ubuntu 20.04 LTS or newer
-   PHP 8.1+ with required extensions
-   MySQL 8.0+ or MariaDB 10.3+
-   Nginx or Apache web server
-   Composer
-   Node.js 16+ and npm
-   SSL certificate (Let's Encrypt recommended)

#### Step-by-Step Deployment

##### 1. Server Setup

Update system packages:

```bash
sudo apt update
sudo apt upgrade -y
```

Install PHP and extensions:

```bash
sudo apt install php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml \
  php8.1-bcmath php8.1-curl php8.1-zip php8.1-gd -y
```

Install MySQL:

```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

Install Nginx:

```bash
sudo apt install nginx -y
```

Install Node.js:

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

Install Composer:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

##### 2. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/gezielcarvalho/air-space-control-website.git
sudo chown -R www-data:www-data air-space-control-website
cd air-space-control-website
```

##### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm ci
npm run build
```

##### 4. Configure Environment

```bash
cp .env.example .env
nano .env
```

Update production values:

```env
APP_NAME="Air Space Control"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=air_space_control
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

##### 5. Generate Keys and Optimize

```bash
php artisan key:generate
php artisan migrate --force
php artisan passport:install --force
php artisan l5-swagger:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

##### 6. Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/air-space-control-website
sudo chmod -R 755 /var/www/air-space-control-website
sudo chmod -R 775 /var/www/air-space-control-website/storage
sudo chmod -R 775 /var/www/air-space-control-website/bootstrap/cache
```

##### 7. Configure Nginx

Create Nginx configuration:

```bash
sudo nano /etc/nginx/sites-available/air-space-control
```

Configuration content:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;

    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    root /var/www/air-space-control-website/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Logging
    access_log /var/log/nginx/air-space-control-access.log;
    error_log /var/log/nginx/air-space-control-error.log;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript
               application/x-javascript application/xml+rss
               application/javascript application/json;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site and restart Nginx:

```bash
sudo ln -s /etc/nginx/sites-available/air-space-control /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

##### 8. Setup SSL with Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

##### 9. Setup Cron Jobs

```bash
sudo crontab -e -u www-data
```

Add Laravel scheduler:

```cron
* * * * * cd /var/www/air-space-control-website && php artisan schedule:run >> /dev/null 2>&1
```

##### 10. Setup Queue Worker (Optional)

Create systemd service:

```bash
sudo nano /etc/systemd/system/air-space-control-worker.service
```

Service configuration:

```ini
[Unit]
Description=Air Space Control Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
RestartSec=3
ExecStart=/usr/bin/php /var/www/air-space-control-website/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

Enable and start service:

```bash
sudo systemctl enable air-space-control-worker
sudo systemctl start air-space-control-worker
```

### Option 2: Docker Deployment

#### Using Docker Compose

##### 1. Ensure Docker is Installed

```bash
docker --version
docker-compose --version
```

##### 2. Configure Environment

```bash
cp .env.example .env
# Edit .env with production values
```

Update database host in `.env`:

```env
DB_HOST=mysql
```

##### 3. Build and Run

```bash
docker-compose up -d --build
```

##### 4. Run Migrations

```bash
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan passport:install --force
```

##### 5. Production Docker Compose

Create `docker-compose.prod.yml`:

```yaml
version: "3.8"

services:
    app:
        build:
            context: .
            dockerfile: Dockerfile
        container_name: air-space-control-app
        restart: unless-stopped
        working_dir: /var/www
        volumes:
            - ./:/var/www
            - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
        networks:
            - app-network
        environment:
            - APP_ENV=production
            - APP_DEBUG=false

    nginx:
        image: nginx:alpine
        container_name: air-space-control-nginx
        restart: unless-stopped
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - ./:/var/www
            - ./docker/nginx/conf.d:/etc/nginx/conf.d
            - ./docker/nginx/ssl:/etc/nginx/ssl
        networks:
            - app-network
        depends_on:
            - app

    mysql:
        image: mysql:8.0
        container_name: air-space-control-mysql
        restart: unless-stopped
        environment:
            MYSQL_DATABASE: ${DB_DATABASE}
            MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
            MYSQL_PASSWORD: ${DB_PASSWORD}
            MYSQL_USER: ${DB_USERNAME}
        volumes:
            - mysql-data:/var/lib/mysql
        networks:
            - app-network

networks:
    app-network:
        driver: bridge

volumes:
    mysql-data:
        driver: local
```

Run with production config:

```bash
docker-compose -f docker-compose.prod.yml up -d
```

### Option 3: Cloud Platform Deployment

#### AWS (Elastic Beanstalk)

1. Install AWS CLI and EB CLI
2. Initialize EB application
3. Configure environment variables
4. Deploy:

```bash
eb init
eb create air-space-control-env
eb deploy
```

#### DigitalOcean App Platform

1. Connect GitHub repository
2. Configure build and run commands
3. Set environment variables
4. Deploy via dashboard

#### Heroku

1. Create Heroku app
2. Add MySQL database addon
3. Configure environment variables
4. Deploy:

```bash
heroku create air-space-control
heroku addons:create cleardb:ignite
git push heroku main
heroku run php artisan migrate --force
```

## Post-Deployment Tasks

### 1. Verify Deployment

```bash
# Check application is accessible
curl -I https://yourdomain.com

# Check API endpoint
curl https://yourdomain.com/api/documentation
```

### 2. Configure Monitoring

Setup monitoring with:

-   **Laravel Telescope** (development/staging only)
-   **New Relic** or **DataDog** for APM
-   **Sentry** for error tracking
-   **Uptime Robot** for uptime monitoring

### 3. Setup Backups

#### Database Backup Script

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/mysql"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="air_space_control"

mkdir -p $BACKUP_DIR
mysqldump -u root -p $DB_NAME > $BACKUP_DIR/backup_$DATE.sql
find $BACKUP_DIR -type f -mtime +7 -delete
```

Add to cron:

```bash
0 2 * * * /path/to/backup-script.sh
```

### 4. Setup Log Rotation

```bash
sudo nano /etc/logrotate.d/air-space-control
```

Configuration:

```
/var/www/air-space-control-website/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

## Performance Optimization

### 1. Enable OPcache

Edit `php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0
opcache.revalidate_freq=0
```

### 2. Setup Redis Cache

Install Redis:

```bash
sudo apt install redis-server -y
```

Update `.env`:

```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Enable HTTP/2

Already enabled in Nginx config if using SSL

## Security Hardening

1. **Firewall Configuration:**

```bash
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable
```

2. **Fail2ban for SSH Protection:**

```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
```

3. **Hide Server Information:**
   In Nginx config, add:

```nginx
server_tokens off;
```

4. **Regular Updates:**

```bash
# Setup automatic security updates
sudo apt install unattended-upgrades -y
sudo dpkg-reconfigure -plow unattended-upgrades
```

## Rollback Strategy

### Git-based Rollback

```bash
cd /var/www/air-space-control-website
git fetch origin
git checkout <previous-commit-hash>
composer install --optimize-autoloader --no-dev
php artisan migrate:rollback
php artisan config:cache
php artisan route:cache
sudo systemctl reload php8.1-fpm
```

## Troubleshooting

### Common Issues

**500 Internal Server Error:**

-   Check storage permissions
-   Verify .env configuration
-   Review error logs: `/var/www/air-space-control-website/storage/logs/laravel.log`

**Database Connection Issues:**

-   Verify database credentials
-   Check MySQL service: `sudo systemctl status mysql`
-   Test connection: `mysql -u username -p`

**Nginx Errors:**

-   Check Nginx error log: `/var/log/nginx/air-space-control-error.log`
-   Test Nginx config: `sudo nginx -t`

## Maintenance Mode

Enable maintenance mode during updates:

```bash
php artisan down --message="Scheduled maintenance" --retry=60
```

Disable after updates:

```bash
php artisan up
```

## Monitoring Commands

```bash
# Check application status
php artisan about

# View logs in real-time
tail -f storage/logs/laravel.log

# Check queue status
php artisan queue:monitor

# Clear all caches
php artisan optimize:clear
```
