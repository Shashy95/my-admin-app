<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Shared\Plan;
use App\Models\Shared\Tenant;
use App\Models\Shared\User;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterTenantController extends Controller
{
    public function __construct(protected BillingService $billing) {}

    public function showForm()
    {
        $plans = Plan::active()->get()->groupBy('product');
        return view('auth.register-tenant', compact('plans'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'phone'         => 'required|string|unique:tenants,phone',
            'email'         => 'required|email|unique:tenants,email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'product'       => 'required|in:mpesa,duka,queue',
        ]);

        DB::transaction(function () use ($request) {

            // Create tenant
            $tenant = Tenant::create([
                'name'          => $request->business_name,
                'slug'          => Str::slug($request->business_name) . '-' . Str::random(4),
                'phone'         => $request->phone,
                'email'         => $request->email,
                'product'       => $request->product,
                'status'        => 'trial',
                'trial_ends_at' => now()->addDays(14),
            ]);

            // Create owner user
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name'      => $request->business_name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
            ]);

            // Assign owner role
            $user->assignRole('owner');

            // Start trial on basic plan
            $plan = Plan::active()
                ->forProduct($request->product)
                ->first();

            if ($plan) {
                $this->billing->startTrial($tenant, $plan);
            }

            // Log in the user
            Auth::login($user);
        });

        return redirect()->route('dashboard');
    }
}