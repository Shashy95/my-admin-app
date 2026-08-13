# Laravel Admin CRUD Starter

A Laravel admin starter with full CRUD, server-side Yajra DataTables, and
Excel/CSV export wired up out of the box — plus a working example module
so you can see the pattern and copy it.

Built because most "Laravel + Yajra + export" guidance online is scattered
across free tutorials and half-finished GitHub repos. This bundles the
pattern into one clean, working starting point.

## What's included

- **BaseCrudController** — list / create / edit / delete / export in ~15
  lines per module (see `ProductController` for the full example)
- **BaseDataTable** — Yajra server-side DataTable with action buttons and
  export buttons pre-wired
- **BaseExport** — Maatwebsite Excel export that mirrors your DataTable's
  filters, so "export what I'm looking at" works by default
- **Tailwind + Alpine.js UI** — no jQuery/Bootstrap conflicts, modal-based
  create/edit forms, clean sidebar layout
- **One fully worked example module** (Products) — copy this file-by-file
  when adding your own modules
- **Demo seeder** — 500 fake rows so search, pagination, and export all
  demo realistically from the first run

## Requirements

- PHP 8.2+
- Laravel 11.x
- Composer

## Quickstart

```bash
# 1. Install dependencies
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

# 6. Serve
php artisan serve
```

Visit `/admin/products` (after logging in / registering) to see the
working example: search, sort, paginate, export to Excel/CSV, and
create/edit/delete via modal — all backed by the base classes.

## Adding your own module

See [`docs/ADDING_A_MODULE.md`](docs/ADDING_A_MODULE.md) — takes about
10 minutes once you're used to the pattern.

## License

MIT — use it in client work or your own products. Attribution appreciated
but not required.
