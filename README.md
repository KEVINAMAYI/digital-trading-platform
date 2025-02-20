# 🛠️ Digital Trading Platform Setup Guide

## 📌 Prerequisites
Before installing Digital Trading Platform ERP, ensure your server meets the following requirements:

- **Web Server:** Apache/Nginx
- **PHP Version:** 8.1 
- **Database:** MySQL

## 🚀 Installation Steps

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/KEVINAMAYI/digital-trading-platform.git
cd digital-trading-platform
```

### 2️⃣ Install Dependencies:
```bash
composer install
```

### 3️⃣ Setup Database
1. Copy the environment file
```bash
cp .env.example .env
```

2. Generate the application key

```bash
php artisan key:generate
```

3. Configure database connection
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
4. Run database migrations
```bash
php artisan migrate
```

5. Seed Data
```bash
php artisan db:seed
```

### 4️⃣ Start the Development Server

1. Build frontend assets (Run this only once after installation or when updating frontend dependencies):

```bash
npm install && npm run dev
```

2. Start Laravel development server

```
php artisan serve
```

3. Open your browser and visit:

```
http://localhost:8000
```

## 🔑 Default Admin Credentials

Use the following credentials to log:

| **Field**   | **Value**              |
|------------|----------------------|
| **Email**  | `admin@admin.com`  |
| **Password** | `password`         |






