## Deploy to InfinityFree (Laravel + MySQL without SSH)

InfinityFree is shared hosting (no SSH / no Composer). So we deploy using:

- Upload **Laravel app** (without `public/`) into a folder like `laravel/`
- Upload **public site** into `htdocs/` with a modified `index.php`
- Import a MySQL schema + seed data via phpMyAdmin

### 1) Create hosting + database

In InfinityFree panel:

- Create a free hosting account + domain/subdomain
- Create a MySQL database + user
- Open phpMyAdmin and import: `database.sql`

### 2) Upload files (File Manager)

In your file manager, you will have a `htdocs/` folder.

Upload:

- `htdocs/` contents from this folder: `deployment/infinityfree/htdocs/*` into your server `htdocs/`
- Create a folder alongside `htdocs/` named `laravel/` and upload everything from `laravel-app/` **EXCEPT** the `public/` folder.

Final server structure:

```
/
  htdocs/
    index.php
    .htaccess
  laravel/
    app/
    bootstrap/
    config/
    database/
    resources/
    routes/
    storage/
    vendor/
    artisan
    composer.json
    ...
```

### 3) Create `.env` on server

Create `laravel/.env` (copy from `laravel/.env.example`) and set:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://<your-domain>`
- `DB_CONNECTION=mysql`
- `DB_HOST=sqlXXX.infinityfree.com` (from InfinityFree)
- `DB_PORT=3306`
- `DB_DATABASE=...`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`

Also set (to avoid needing Redis/DB cache):

- `CACHE_STORE=file`
- `SESSION_DRIVER=file`
- `QUEUE_CONNECTION=sync`

### 4) Writable folders

Ensure these are writable:

- `laravel/storage/`
- `laravel/bootstrap/cache/`

### 5) URLs (once deployed)

- `/blogs`
- `/admin/login` (admin@blog.test / password)

