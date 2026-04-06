<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    </a>
    <a href="https://vuejs.org" target="_blank">
        <img src="https://img.shields.io/badge/Vue.js-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white" alt="Vue.js">
    </a>
    <a href="https://inertiajs.com" target="_blank">
        <img src="https://img.shields.io/badge/Inertia.js-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia.js">
    </a>
    <a href="https://tailwindcss.com" target="_blank">
        <img src="https://img.shields.io/badge/TailwindCSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
    </a>
</p>

<p align="center">
    <a href="https://www.mysql.com">
        <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    </a>
    <a href="https://www.php.net">
        <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
    </a>
    <a href="https://vite.dev">
        <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
    </a>
    <a href="https://git-scm.com">
        <img src="https://img.shields.io/badge/Git-F05033?style=for-the-badge&logo=git&logoColor=white" alt="Git">
    </a>
</p>

<h1 align="center">SpendTrack</h1>

<p align="center">
    <strong>Personal expense tracking system</strong><br />
    Modern, fast, and elegant. Built with Laravel, Vue.js, Inertia.js, and TailwindCSS.
</p>

<br />

<p align="center">
    <img src="https://via.placeholder.com/900x450?text=SpendTrack+Dashboard" alt="Dashboard Preview" width="85%" style="border-radius: 16px; box-shadow: 0 25px 40px -12px rgba(0,0,0,0.25);">
</p>

---

## Features

| Area | Description |
|------|-------------|
| Dashboard | Interactive charts and spending overview by category |
| Transactions | Add, edit, and delete income or expenses instantly |
| Categories | Fully customizable spending categories |
| Filters | Filter by date range or category |
| Authentication | Secure login, registration, and password reset |
| Responsive | Works perfectly on desktop, tablet, and mobile |

---

## Technology Stack

| Technology | Purpose |
|------------|---------|
| Laravel 11 | Backend framework, authentication, database ORM |
| Vue.js 3 | Reactive frontend components |
| Inertia.js | SPA experience without building a separate API |
| TailwindCSS | Utility-first CSS for modern responsive design |
| MySQL | Relational database |
| Vite | Frontend build tool and hot module replacement |

---

## Requirements

Before installing, ensure you have the following:

- PHP >= 8.2
- Composer
- Node.js (v18 or higher) and NPM
- MySQL (or MariaDB)

---

## Installation

Follow these steps to set up SpendTrack locally:

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/spendtrack.git
cd spendtrack

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Run database migrations and seeders
php artisan migrate --seed

# 7. Start the Vite development server (keep this running)
npm run dev

# 8. In a new terminal, start the Laravel development server
php artisan serve
