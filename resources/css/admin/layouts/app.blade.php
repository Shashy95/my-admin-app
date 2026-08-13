<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · CrudKit</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#12141C',
                        paper: '#F5F4EF',
                        forest: { DEFAULT: '#2F6F4E', 50: '#EAF3EE', 100: '#D3E7DA', 600: '#2F6F4E', 700: '#245839' },
                        gold: { DEFAULT: '#D8A24A', 100: '#F7EBD3' },
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['"IBM Plex Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }

        .dataTables_wrapper { font-family: inherit; }
        table.dataTable { border-collapse: separate !important; border-spacing: 0; width: 100% !important; }
        table.dataTable thead th {
            background: #FAFAF7;
            color: #6b7280;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.75rem 1rem !important;
            border-bottom: 1px solid #e5e7eb !important;
        }
        table.dataTable tbody td {
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid #f3f4f6 !important;
        }
        table.dataTable tbody tr:hover { background-color: #FAFAF7; }
        table.dataTable.stripe tbody tr.odd,
        table.dataTable.display tbody tr.odd { background-color: #fff; }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info {
            font-size: 0.875rem;
            color: #6b7280;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .dataTables_wrapper .dataTables_filter input { margin-left: 0.5rem; }

        .dataTables_wrapper .dataTables_paginate { padding-top: 0.75rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid transparent !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            margin-left: 0.125rem;
            font-size: 0.875rem;
            color: #374151 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #EAF3EE !important;
            border-color: #D3E7DA !important;
            color: #245839 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2F6F4E !important;
            border-color: #2F6F4E !important;
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { color: #d1d5db !important; }
        table.dataTable.select tbody tr.selected { background-color: #EAF3EE; }
    </style>
</head>
<body class="h-full bg-paper">
<div class="min-h-full flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-ink text-gray-300 flex-shrink-0 hidden md:flex md:flex-col">
        <div class="h-16 flex items-center gap-2.5 px-6">
            <span class="font-mono text-forest-100 bg-forest-600/30 border border-forest-600/50 rounded w-6 h-6 flex items-center justify-center text-sm">&gt;</span>
            <span class="font-display font-semibold text-white tracking-tight">CrudKit</span>
        </div>
        <nav class="flex-1 px-3 space-y-0.5 mt-2">
            @php $navLink = fn($active) => 'flex items-center gap-2 px-3 py-2 text-sm font-medium border-l-2 transition-colors ' . ($active ? 'border-forest text-white bg-white/5' : 'border-transparent text-gray-400 hover:text-white hover:bg-white/5'); @endphp

            <a href="{{ route('admin.dashboard') }}" class="{{ $navLink(request()->routeIs('admin.dashboard')) }}">
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ $navLink(request()->routeIs('admin.products.*')) }}">
                Products
            </a>
            {{-- Add new module links here as you build them out --}}

            <div class="pt-4 mt-4 border-t border-white/10 space-y-0.5">
                <a href="{{ route('admin.settings.index') }}" class="{{ $navLink(request()->routeIs('admin.settings.*')) }}">
                    Settings
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="{{ $navLink(request()->routeIs('admin.profile.*')) }}">
                    Profile
                </a>
            </div>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 justify-between">
            <h1 class="font-display text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
        </header>

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</div>

{{-- Global delete confirmation modal --}}
<div
    x-data="{ open: false, url: '' }"
    x-show="open"
    x-cloak
    @confirm-delete.window="open = true; url = $event.detail.url"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[110] overflow-y-auto"
    style="display: none;"
>
    <div class="fixed inset-0 bg-black/30" @click="open = false"></div>
    <div class="relative min-h-full flex items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-sm p-6" @click.stop>
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Delete this record?</h3>
                    <p class="text-sm text-gray-500 mt-1">This action cannot be undone.</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="open = false"
                        class="px-3 py-2 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form :action="url" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 text-sm rounded-md bg-red-600 text-white hover:bg-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Toast notification --}}
@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-4 right-4 z-[100] max-w-sm"
    >
        <div class="flex items-start gap-3 bg-white border border-forest-100 shadow-lg rounded-lg px-4 py-3">
            <svg class="w-5 h-5 text-forest flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25 4.5-4.5m4.5 2.25a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-gray-700">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

@stack('scripts')
</body>
</html>
