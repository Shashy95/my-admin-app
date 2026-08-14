# CrudKit — Laravel Admin Starter

A complete Laravel admin panel starter: full CRUD, server-side Yajra
DataTables, Excel/PDF export, a dashboard with charts, settings, user
profile, and access control — all wired up out of the box, with a
distinctive design instead of default Tailwind/indigo.

Built because most "Laravel + Yajra + export" guidance online is scattered
across free tutorials and half-finished GitHub repos. This bundles the
pattern into one clean, working, good-looking starting point.

## What's included

- **BaseCrudController** — list / create / edit / delete / export in ~15
  lines per module (see `ProductController` for the full worked example)
- **BaseDataTable** — Yajra server-side DataTable, custom-styled to match
  the admin theme (not default jQuery DataTables look)
- **BaseExport** — Maatwebsite export supporting Excel, CSV, and PDF
  (via dompdf), mirroring your DataTable's filters so "export what I'm
  looking at" works by default
- **Dashboard** — stat cards + Chart.js charts (status breakdown, 7-day
  trend), built from live data
- **Settings** — a simple key/value settings screen (app name, support
  email, etc.) — the app name you set here reflects live in the sidebar
  and browser tab
- **Profile** — the logged-in user can update their name/email and
  change their password
- **Admin access control** — an `is_admin` flag + middleware restricts
  `/admin` to admin users only; the first person to register on a fresh
  install is auto-promoted to admin
- **Restyled auth** — login and register pages match the admin's design
  system, not Breeze's default look
- **Distinctive design system** — forest/gold/ink palette, Space
  Grotesk + Inter + IBM Plex Mono typography, left-accent-bar nav,
  dot-badge status pills — configurable in one `tailwind.config` block
  per page
- **Responsive** — sidebar becomes a slide-in mobile drawer below the
  `md` breakpoint
- **Icon-based row actions + custom confirm modal** — no native browser
  `alert()`/`confirm()` anywhere in the UI
- **Toast notifications** — success messages appear top-right and
  auto-dismiss
- **One fully worked example module** (Products) — copy this file-by-file
  when adding your own modules
- **Demo seeder** — 500 fake rows so search, pagination, and export all
  demo realistically from the first run

## Requirements

- PHP 8.3+
- Laravel 13.x
- Composer
- Node (for Breeze's asset build)

## Quickstart

```bash
# 1. Create a fresh Laravel project, then copy this kit's app/, database/,
#    resources/, and routes/admin.php into it (see "Setup on a fresh
#    Laravel install" below if starting from zero)
composer install

# 2. Copy env and generate key
cp .env.example .env
php artisan key:generate

# 3. Set your DB credentials in .env, then migrate
php artisan migrate

# 4. Seed demo data (500 fake products)
php artisan db:seed --class=DemoDataSeeder

# 5. Set up auth scaffolding (Breeze)
php artisan breeze:install blade
npm install && npm run build

# 6. Register middleware alias (see "Admin access control" below)

# 7. Serve
php artisan serve
```

Register your first account — it's automatically made an admin. Visit
`/admin` to see the dashboard, then `/admin/products` for the full
working CRUD example: search, sort, paginate, export to Excel/CSV/PDF,
and create/edit/delete via modal.

## Admin access control

Only users with `is_admin = true` can access `/admin`. The first
registered user is promoted automatically; anyone who registers after
that needs to be promoted manually:

```bash
php artisan tinker
>>> User::find(2)->update(['is_admin' => true]);
```

This requires registering the `admin` middleware alias in
`bootstrap/app.php`, inside `->withMiddleware()`:

```php
$middleware->alias([
    'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
]);
```

## Customizing the brand

- **Name**: Settings → App Name (reflects live in the sidebar/title), or
  set a fallback via `APP_NAME` in `.env`
- **Colors/fonts**: each page (`admin/layouts/app.blade.php`,
  `auth/login.blade.php`, `auth/register.blade.php`) has its own
  `tailwind.config` script block — edit the `forest`/`gold`/`ink`/`paper`
  color values and `fontFamily` entries to rebrand

## Adding your own module

See [`docs/ADDING_A_MODULE.md`](ADDING_A_MODULE.md) — takes about
10 minutes once you're used to the pattern.

## License

MIT — use it in client work or your own products. Attribution appreciated
but not required.