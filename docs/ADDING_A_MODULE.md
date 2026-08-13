# Adding a new module

This walks through adding a "Customers" module, mirroring the Products
example exactly. Once you've done this once, it takes about 10 minutes
per module.

## 1. Migration + Model

```bash
php artisan make:model Customer -m
```

Edit the migration, add your columns, then:

```bash
php artisan migrate
```

## 2. DataTable class

`app/DataTables/CustomerDataTable.php`:

```php
<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Html\Column;

class CustomerDataTable extends BaseDataTable
{
    public function query()
    {
        return Customer::query()->select(['id', 'name', 'email', 'phone', 'created_at']);
    }

    protected function columns(): array
    {
        return [
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('created_at')->title('Joined'),
        ];
    }

    protected function routePrefix(): string
    {
        return 'customers';
    }
}
```

## 3. Export class

`app/Exports/CustomerExport.php` — copy `ProductExport.php`, swap the
model, headings, and `map()` fields.

## 4. Controller

`app/Http/Controllers/Admin/CustomerController.php` — copy
`ProductController.php`, swap `modelClass()`, `rules()`,
`dataTableClass()`, `exportClass()`, and `viewNamespace()`.

## 5. View

Copy `resources/views/admin/examples/products/index.blade.php` to
`resources/views/admin/examples/customers/index.blade.php`. Update:
- the Alpine `form` object fields
- the modal form inputs
- the route names (`admin.customers.*`)

## 6. Routes

In `routes/admin.php`, copy the six Products route lines and swap
`products` → `customers` and `ProductController` → `CustomerController`.

Or use the one-liner via `HasCrudRoutes`:

```php
Route::crudModule('customers', CustomerController::class);
```

## 7. Sidebar link

Add a link in `resources/views/admin/layouts/app.blade.php` next to the
Products link.

That's it — full CRUD, search, sort, pagination, and export for the new
module.
