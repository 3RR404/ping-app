# ping-app

A full-stack app with a Vue 3 frontend and a Laravel API backend, orchestrated via Docker Compose.

## Services

| Service              | URL                    |
|----------------------|------------------------|
| Frontend (Vue 3)     | http://localhost:8080  |
| Backend API (Laravel)| http://localhost:8000  |
| MySQL                | localhost:3307         |

## Setup

1. **Clone the repo**

   ```bash
   git clone git@github.com:3RR404/ping-app.git
   cd ping-app
   cp backend/.env.example backend/.env
   ```

2. **Build and start all containers**

   ```bash
   docker compose up -d
   ```

   On first run Docker will build all images and wait for MySQL to become healthy before starting the app.

3. **Install dependencies and run database migrations**:

   ```bash
   docker exec -i -t ping-php-fpm sh
   composer install
   php artisan key:generate
   php artisan migrate
   ```

The app is now running. Open http://localhost:8080 in your browser.

## Frontend development
To run the frontend in development mode,

```bash
cd frontend
npm install
npm run dev
```
