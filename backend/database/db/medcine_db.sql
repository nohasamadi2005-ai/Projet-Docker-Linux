name: CI Laravel Medical App

on:
  push:
    branches: [ "dev", "main" ]
  pull_request:
    branches: [ "dev", "main" ]

jobs:
  laravel-tests:
    name: Backend Tests (Laravel + PHPUnit)
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: medcine_db_test
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping --silent"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: mbstring, dom, curl, mysql

      - name: Install dependencies
        run: cd backend && composer install --no-interaction --prefer-dist

      - name: Setup environment
        run: |
          cd backend
          cp .env.example .env
          php artisan key:generate

      - name: Configure database
        run: |
          cd backend
          sed -i 's/DB_DATABASE=.*/DB_DATABASE=medcine_db_test/' .env
          sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/' .env
          sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/' .env

      - name: Run migrations
        run: cd backend && php artisan migrate --force

      - name: Run PHPUnit tests
        run: cd backend && ./vendor/bin/phpunit


  frontend-tests:
    name: Frontend Tests (Angular)
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: 18

      - name: Install dependencies
        run: cd frontend && npm install

      - name: Run Angular tests
        run: cd frontend && npm test -- --watch=false --browsers=ChromeHeadless


  docker-build:
    name: Docker Build Check
    runs-on: ubuntu-latest
    needs: [laravel-tests, frontend-tests]

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Build Docker images
        run: docker compose build