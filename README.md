# 🎓 Laravel Educational Platform

This is a Laravel-based educational platform designed for schools, universities, and teachers.  
Follow the steps below to set up and run the project locally.

---

## 🖥️ Requirements

- PHP **8.3**
- Composer
- MySQL or MariaDB
- Recommended: [Laragon](https://laragon.org/) or [XAMPP](https://www.apachefriends.org/index.html) with PHP 8.3

---

## ⚙️ Installation Steps

### 1. Clone the Repository

If you are using Git:

```bash
git clone https://github.com/dpsoft-labs/elearning.git
cd elearning
```

Or just download and extract the ZIP file.

---

### 2. Start Your Server (Laragon or XAMPP)

Make sure Apache and MySQL are running.

Put the project folder inside:

- `C:\laragon\www` (for Laragon)
- `C:\xampp\htdocs` (for XAMPP)

---

### 3. Create the `.env` File

Copy the environment example file:

```bash
cp .env.example .env
```

---

### 4. Install Dependencies

Use Composer to install PHP dependencies:

```bash
composer install
```

---

### 5. Generate App Key

Run the following command:

```bash
php artisan key:generate
```

---

### 6. Set Up the Database

Create a new database in phpMyAdmin or MySQL (e.g., `education_db`)

Update the `.env` file with your database info:

```env
DB_DATABASE=education_db
DB_USERNAME=root
DB_PASSWORD=
```

Adjust `DB_USERNAME` and `DB_PASSWORD` as needed.

---

### 7. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create all tables and insert the default admin account.

---

## 🔐 Admin Login

Use the following credentials to access the admin panel:

- **Email:** `admin@admin.com`
- **Password:** `01000100`

---

## 🚀 Run the Project

Start the Laravel development server:

```bash
php artisan serve
```

Then open your browser and go to:  
[http://localhost:8000](http://localhost:8000)

---

## 📄 License

This project is for educational and commercial use. Customization and branding are permitted under license.
