@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div x-data="{
        open: false,
        editing: false,
        form: { id: null, name: '', sku: '', price: '', stock: '', status: 'active' },
        newRecord() {
            this.editing = false;
            this.form = { id: null, name: '', sku: '', price: '', stock: '', status: 'active' };
            this.open = true;
        }
     }"
     @edit-record.window="
        editing = true;
        form = { id: $event.detail.id, name: $event.detail.name, sku: $event.detail.sku, price: $event.detail.price, stock: $event.detail.stock, status: $event.detail.status };
        open = true;
     "
>
    <div class="flex justify-between items-center mb-4">
        <p class="text-sm text-gray-500">Full CRUD + search + export, wired to the base classes.</p>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.export', ['format' => 'xlsx']) }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                Export Excel
            </a>
            <a href="{{ route('admin.products.export', ['format' => 'pdf']) }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                Export PDF
            </a>
            <button @click="newRecord()"
                    class="px-4 py-2 bg-forest text-white text-sm font-medium rounded-md hover:bg-forest-700">
                + Add Product
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-4">
        {{ $dataTable->html()->table(['class' => 'display w-full text-sm']) }}
    </div>

    {{-- Create modal --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/30" @click="open = false"></div>

        <div class="relative min-h-full flex items-center justify-center p-4">
            <form :action="editing ? `/admin/products/${form.id}` : '{{ route('admin.products.store') }}'"
                  method="POST"
                  class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6" @click.stop>
                @csrf
                <template x-if="editing">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <h2 class="text-base font-semibold text-gray-900 mb-4" x-text="editing ? 'Edit Product' : 'Add Product'"></h2>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" x-model="form.name" required
                               class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" x-model="form.sku" required
                               class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Price</label>
                            <input type="number" step="0.01" name="price" x-model="form.price" required
                                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock" x-model="form.stock" required
                                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select name="status" x-model="form.status" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-3 py-2 text-sm rounded-md bg-forest text-white hover:bg-forest-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->html()->scripts() }}
@endpush
