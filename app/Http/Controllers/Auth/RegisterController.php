<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(StoreRegisterRequest $request): RedirectResponse
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->validated('owner_name'),
                'email' => $request->validated('email'),
                'password' => Hash::make($request->validated('password')),
            ]);

            Store::create([
                'user_id' => $user->id,
                'name' => $request->validated('shop_name'),
                'whatsapp_number' => $request->validated('whatsapp_number'),
                'location' => $request->validated('location'),
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('status', 'Welcome to WingaX! Add your first product to go live.');
    }
}
