<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

/**
 * HasCrudRoutes
 *
 * Registers index/data/store/update/destroy/export routes for a module
 * in one line instead of six. Use in routes/admin.php:
 *
 *   Route::crudModule('products', ProductController::class);
 */
trait HasCrudRoutes
{
    public static function registerCrudRoutes(string $prefix, string $controller): void
    {
        Route::get("{$prefix}", [$controller, 'index'])->name("admin.{$prefix}.index");
        Route::get("{$prefix}/data", [$controller, 'data'])->name("admin.{$prefix}.data");
        Route::post("{$prefix}", [$controller, 'store'])->name("admin.{$prefix}.store");
        Route::put("{$prefix}/{id}", [$controller, 'update'])->name("admin.{$prefix}.update");
        Route::delete("{$prefix}/{id}", [$controller, 'destroy'])->name("admin.{$prefix}.destroy");
        Route::get("{$prefix}/export", [$controller, 'export'])->name("admin.{$prefix}.export");
    }
}
