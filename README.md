## Blog Management System (Laravel + MySQL)

This project satisfies the assignment requirements:

- **User side**: blog listing + blog detail pages (responsive)
- **Dynamic search + filter**: category + date + search using **AJAX + jQuery** (no reload)
- **Admin panel**: login + add/edit/delete blogs (with image upload)
- **Database**: MySQL (Laravel migrations/seeders included)

### What’s in this repository

Because this environment doesn’t have PHP/Composer installed, the Laravel app is provided as an **override bundle** you can apply onto a freshly created Laravel project.

- `overrides/`: assignment-specific Laravel code (routes/controllers/models/views/assets/migrations/seeders)
- `install.sh`: creates a Laravel project and copies `overrides/` into it

### Prerequisites (local machine)

- PHP 8.2+
- Composer 2
- MySQL 8+
- Node.js 18+ (optional; only needed if you run Vite/build steps)

### Setup

1. Open a terminal in this folder.
2. Run:

```bash
bash install.sh
```

3. Create a MySQL database, for example:

```sql
CREATE DATABASE blog_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Configure `.env` in `laravel-app/`:

```bash
cp laravel-app/.env.example laravel-app/.env
```

Set:

- `DB_DATABASE=blog_management`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`

5. Install + migrate + seed:

```bash
cd laravel-app
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

### URLs

- **User**
  - `/` (redirects to `/blogs`)
  - `/blogs`
  - `/blogs/{blog:slug}`
- **Admin**
  - `/admin/login`
  - `/admin/blogs`

### Admin credentials (seeded)

- **Email**: `admin@blog.test`
- **Password**: `password`

### AJAX filtering (mandatory)

On `/blogs`, search/filter controls use jQuery AJAX to call `/blogs` with query params:

- `q`: text search
- `category`: category name
- `from`: start date (YYYY-MM-DD)
- `to`: end date (YYYY-MM-DD)

The server returns JSON containing rendered HTML for the list, which is injected without reloading the page.

