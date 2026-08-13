{{--
    Generic slide-over/modal shell driven by Alpine state (open, editing, form).
    Include this in a module's index view and yield the actual form fields
    via the $slot-like @section pattern shown in examples/products/index.blade.php.
--}}
<div
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="fixed inset-0 bg-black/30" @click="open = false"></div>

    <div class="relative min-h-full flex items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg p-6"
             @click.stop>
            <h2 class="text-base font-semibold text-gray-900 mb-4" x-text="editing ? 'Edit record' : 'Add record'"></h2>

            {{ $slot ?? '' }}

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="open = false"
                        class="px-3 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-3 py-2 text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-500">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
