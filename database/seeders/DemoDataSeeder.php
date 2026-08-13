<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Seeds 500 fake products so the DataTable, search, pagination, and
 * export buttons all demo realistically -- an empty table looks broken
 * in a sales screenshot/demo video.
 *
 * Run: php artisan db:seed --class=DemoDataSeeder
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(500)->create();
    }
}
