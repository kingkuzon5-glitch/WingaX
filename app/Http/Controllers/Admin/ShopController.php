<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function edit(): View
    {
        $store = Auth::user()->store;

        return view('admin.shop.edit', compact('store'));
    }

    public function update(UpdateShopRequest $request): RedirectResponse
    {
        $store = Auth::user()->store;
        $data = $request->safe()->except(['avatar', 'cover']);

        if ($request->hasFile('avatar')) {
            if ($store->avatar_path) {
                Storage::disk('public')->delete($store->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('stores', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($store->cover_path) {
                Storage::disk('public')->delete($store->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('stores', 'public');
        }

        $store->update($data);

        return back()->with('status', 'Shop profile updated.');
    }
}
