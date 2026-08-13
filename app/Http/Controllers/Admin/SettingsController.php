<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * Simple key-value settings screen. Add more fields by:
 *   1. adding an input to resources/views/admin/settings/index.blade.php
 *   2. adding its key to the $keys array below
 */
class SettingsController extends Controller
{
    protected array $keys = ['app_name', 'support_email', 'low_stock_threshold'];

    public function index()
    {
        $settings = collect($this->keys)
            ->mapWithKeys(fn ($key) => [$key => Setting::get($key)]);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'support_email' => 'nullable|email|max:255',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings saved.');
    }
}
