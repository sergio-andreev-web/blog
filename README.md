# Blog

This project uses Laravel as the backend, Vue.js 2 for the frontend, MySQL as the database, and Nginx as the web server.

## Prerequisites

- Docker
- Docker Compose
- Node.js and npm
- Composer

## Getting Started

Follow these steps to set up and run the project locally:

1. **Copy the `.env` file:**

   ```bash
      cp .env.example .env
   ```
2. Navigate to the frontend directory and install dependencies:

   ```bash
      cd front
      npm install
      cd ..
   ```

3. Navigate to the Laravel directory and install PHP dependencies:

   ```bash
      cd laravel
      composer install
      cd ..
   ```

4. Start Docker containers:

   ```bash
      docker-compose up -d --build
   ```
   
5. Run database migrations:

   ```bash
      cd laravel
      php artisan migrate
   ```

6. Install Laravel Passport (for API authentication):

   ```bash
      php artisan passport:install
   ```

7. Seed the database with initial data:

   ```bash
      php artisan db:seed
   ```
