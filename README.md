# Sembark URL Shortener

A URL shortener with multiple companies, built with Laravel 12 and MySQL.

| Role | Can do |
|---|---|
| SuperAdmin | Invite a new client (company + its Admin), see all clients on the dashboard. Click a client's **Users** count to see its users, or its **Total Generated URLs** count to see its short URLs. `/short-urls` lists short URLs of every company. Cannot create short URLs. |
| Admin | Invite Admin/Member in own company, create short URLs, see all short URLs of own company. |
| Member | Create short URLs, see only own short URLs. |

Short URLs (`/s/{code}`) are public and redirect to the original URL.

## Setup

Requires PHP 8.2+, Composer and MySQL.

```bash
git clone <repo-url>
cd sembark-url-shortener
composer install
cp .env.example .env
php artisan key:generate
```

Create a MySQL database and update `.env`:

```
DB_DATABASE=sembark_url_shortener
DB_USERNAME=root
DB_PASSWORD=

SUPERADMIN_EMAIL=superadmin@sembark.com
SUPERADMIN_PASSWORD="Sembark@12345"
```

Then run:

```bash
php artisan migrate
php artisan db:seed     # creates the SuperAdmin
php artisan serve
```

Open http://127.0.0.1:8000 and log in as SuperAdmin.

## Invitation emails

By default `MAIL_MAILER=log`, so **no real email is sent**. After sending an invite, the accept link is shown on the dashboard and also written to `storage/logs/laravel.log`. Open that link (logged out), set a name and password, and the account is created.

To send real emails, set the SMTP details in `.env` (`MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, etc.) and run `php artisan config:clear`.
