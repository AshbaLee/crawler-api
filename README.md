# My first crawler

### Step 1: Copy env
cp .env.example .env

cp docker/.env.example docker/.env

cp docker/mysql/docker-entrypoint-initdb.d/createdb.sql.example docker/mysql/docker-entrypoint-initdb.d/createdb.sql

### Step 2: Run docker-compose
cd docker
docker-compose up -d mysql nginx php www

### Step 3: Run composer install & migration in www container
docker exec -it --user=ashba crawler_www_1 bash
composer install
php artisan migrate

### Step 4: Open localhost in browser
http://localhost
