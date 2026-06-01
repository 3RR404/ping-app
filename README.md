# ping-app

A full-stack app with a Vue 3 frontend and a Laravel API backend, orchestrated via Docker Compose.

## Services

| Service              | URL                    |
|----------------------|------------------------|
| Backend API (Laravel)| http://localhost:8000  |
| MySQL                | localhost:3307         |

## Setup

1. **Clone the repo**

   ```bash
   git clone git@github.com:3RR404/ping-app.git
   cd ping-app
   cp .env.example .env
   ```

2. **Build and start all containers**

   ```bash
   docker compose up -d
   ```

   On first run Docker will build all images and wait for MySQL to become healthy before starting the app.

3. **Install dependencies and run database migrations**:

   ```bash
   docker exec -it ping-php-fpm composer install
   docker exec -it ping-php-fpm php artisan key:generate
   docker exec -it ping-php-fpm php artisan migrate
   ```

The app is now running. Open http://localhost:8000 in your browser.

## Testing

Run api tests for
- creates device  
- stores ping for existing device
- returns device detail
- ping returns 404 for unknown device
- device detail returns 404 for unknown uuid

validation tests:

- create device fails validation when uuid missing invalid or name is missing
- ping fails validation when battery percent is missing, above max or below min

```bash
docker exec -i -t ping-php-fpm sh
php artisan test --filter DeviceApiTest
```

## API Documentation

Documentation of api endpoints is serving by l5-swagger. Complete API endpoitns documentation can be found at http://localhost:8000/api/documentation
To generate swagger documentation run:

```bash
docker exec -it ping-php-fpm php artisan l5-swagger:generate
```
