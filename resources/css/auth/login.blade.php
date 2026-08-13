<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in · CrudKit</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#12141C',
                        paper: '#F5F4EF',
                        forest: { DEFAULT: '#2F6F4E', 50: '#EAF3EE', 700: '#245839' },
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
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="h-full bg-paper">
<div class="min-h-full flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-11 h-11 rounded-lg bg-ink text-forest-50 font-mono text-lg mb-4">&gt;</div>
            <h1 class="font-display text-xl font-semibold text-gray-900">Welcome back</h1>
            <p class="text-sm text-gray-500 mt-1">Log in to CrudKit</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-forest-50 border border-forest-100 px-4 py-3 text-sm text-forest-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-forest">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-forest focus:ring-forest">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-forest hover:text-forest-700">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-2 bg-forest text-white text-sm font-medium rounded-md hover:bg-forest-700">
                    Log in
                </button>
            </form>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-forest hover:text-forest-700 font-medium">Sign up</a>
            </p>
        @endif
    </div>
</div>
</body>
</html>
