# MagicCMS VPS Deploy Заавар (Ubuntu 22.04/24.04)

## 1. Серверийн анхны тохиргоо

### SSH-ээр сервер рүү холбогдох
```bash
ssh root@YOUR_SERVER_IP
```

### Системийг шинэчлэх
```bash
apt update && apt upgrade -y
```

### Шаардлагатай програмуудыг суулгах
```bash
apt install -y nginx postgresql postgresql-contrib redis-server supervisor git curl unzip
```

### PHP 8.3 суулгах
```bash
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.3-fpm php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath php8.3-redis
```

### Composer суулгах
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

### Node.js 20 суулгах
```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
```

---

## 2. PostgreSQL тохируулах

```bash
sudo -u postgres psql
```

PostgreSQL дотор:
```sql
CREATE USER intax_user WITH PASSWORD 'your_secure_password';
CREATE DATABASE intax_db OWNER intax_user;
GRANT ALL PRIVILEGES ON DATABASE intax_db TO intax_user;
\q
```

---

## 3. Хэрэглэгч үүсгэх

```bash
useradd -m -s /bin/bash deployer
usermod -aG www-data deployer
mkdir -p /var/www
chown -R deployer:www-data /var/www
```

---

## 4. Код татах

```bash
cd /var/www
git clone YOUR_REPO_URL intax
cd intax
chown -R deployer:www-data .
```

---

## 5. Laravel тохируулах

### .env файл үүсгэх
```bash
cp .env.example .env
nano .env
```

### .env файлын чухал тохиргоонууд:
```env
APP_NAME="MagicCMS"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=intax_db
DB_USERNAME=intax_user
DB_PASSWORD=your_secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=database

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Composer, npm суулгах
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

### Laravel тохиргоо
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --force
php artisan db:seed --force  # Анхны удаа л ажиллуулна
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Эрх тохируулах
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 6. Nginx тохируулах

```bash
cp nginx.conf.example /etc/nginx/sites-available/intax
nano /etc/nginx/sites-available/intax
# Домэйн нэрээ засна

ln -s /etc/nginx/sites-available/intax /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

---

## 7. SSL сертификат (Let's Encrypt)

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d your-domain.com -d www.your-domain.com
```

---

## 8. Supervisor тохируулах (Queue Worker)

```bash
cp supervisor.conf.example /etc/supervisor/conf.d/intax-worker.conf
supervisorctl reread
supervisorctl update
supervisorctl start intax-worker:*
```

---

## 9. Cron тохируулах (Laravel Scheduler)

```bash
crontab -e
```

Доорх мөрийг нэмнэ:
```
* * * * * cd /var/www/intax && php artisan schedule:run >> /dev/null 2>&1
```

---

## 10. Дараагийн deploy хийхэд

SSH-ээр холбогдоод:
```bash
cd /var/www/intax
./deploy.sh
```

Эсвэл гараар:
```bash
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear
php artisan queue:restart
```

---

## Firewall тохиргоо (UFW)

```bash
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw enable
```

---

## Алдаа шалгах

```bash
# Laravel логууд
tail -f /var/www/intax/storage/logs/laravel.log

# Nginx логууд
tail -f /var/log/nginx/intax-error.log

# PHP-FPM статус
systemctl status php8.3-fpm

# Queue worker статус
supervisorctl status
```
