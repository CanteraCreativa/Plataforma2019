# Web module
This module contains all the necessary parts for the back & frontend stuff. The environment is replicated using `docker`, with the configuration found in the `docker_config` subdirectory. The `Laravel` application is found in the `app` subdirectory.

## Docker

### Starting the containers
For starting all the necessary containers:

```bash
# From <repo_root>/docker_config
cp .env.dev .env

docker-compose up -d nginx mysql phpmyadmin workspace
```

The first time this command is run, all the necessary images will be downloaded (might take a while), and then configured and fired up. This will, for example, create the database needed for the Laravel application.

```
# MySQL / PhpMyAdmin credentials
database: default
user: default
password: secret
```

By default, the app will be served on port 80 (`http://localhost`), and the PHPMyAdmin on port 8080 (`http://localhost:8080`)

### Stopping the containers
For stoping all containers (no data will be lost!):

```bash
# From <repo_root>/docker_config
docker-compose down
```

## Laravel
Once the containers are running, the initial setup can be run.

#### 1. Login to the workspace container

```bash
docker-compose exec --user=laradock workspace bash
```

The following commands will be run inside the container, until you type `exit`.

#### 2. Install PHP dependencies

```bash
composer install
```

#### 3. Generate the Laravel app key
```bash
php artisan key:generate
```

#### 4. Run the Laravel migrations and seeders
```bash
php artisan migrate:install
php artisan migrate
php artisan db:seed
```

#### 5. Generate Passport keys
```bash
php artisan passport:keys
```

#### 6. Link the storage to public
```bash
php artisan storage:link
```

#### 7. Install NodeJS dependencies
```bash
npm install
```

#### 8. Process JS and CSS assets
```bash
# For development watching - compiles files listed in webpack.mix.js when a file in the dependency tree is saved
npm run watch

# For development compiling
npm run dev

# For production compiling
npm run prod
```
