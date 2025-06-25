# Instaclone 📸

A simple Instagram clone built using **Laravel 12**, **MySQL**, and **Bootstrap 5**.

---

## 🚀 Features

- User registration and authentication
- Post creation with image uploads
- Like and comment system
- Profile pages
- Responsive UI with Bootstrap 5

---

## 🛠 Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Blade

---

## 📦 Installation

Follow these steps to get the project up and running:

```bash
# 1. Clone the repository
git clone https://github.com/protex121/igclone.git
cd instaclone

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create .env file and set up your DB credentials
cp .env.example .env
php artisan key:generate

# 5. Link storage
php artisan storage:link

# 6. Run migrations
php artisan migrate


## 📦 Runnning Project
Follow these steps to get the project up and running:

# Start the Laravel development server
php artisan serve

# Start the frontend build process
npm run dev
