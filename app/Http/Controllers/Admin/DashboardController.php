<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\WhatsappClick;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $storeId = Auth::user()->store->id;

        $weekAgo = Carbon::now()->subDays(7);
        $twoWeeksAgo = Carbon::now()->subDays(14);

        $viewsThisWeek = ProductView::where('store_id', $storeId)->where('created_at', '>=', $weekAgo)->count();
        $viewsPrevWeek = ProductView::where('store_id', $storeId)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();

        $clicksThisWeek = WhatsappClick::where('store_id', $storeId)->where('created_at', '>=', $weekAgo)->count();
        $clicksPrevWeek = WhatsappClick::where('store_id', $storeId)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();

        $stats = [
            'total_views' => ProductView::where('store_id', $storeId)->count(),
            'total_views_change' => $this->percentChange($viewsPrevWeek, $viewsThisWeek),
            'total_clicks' => WhatsappClick::where('store_id', $storeId)->count(),
            'total_clicks_change' => $this->percentChange($clicksPrevWeek, $clicksThisWeek),
            'active_deals' => Product::where('store_id', $storeId)->published()->deals()->count(),
            'total_products' => Product::where('store_id', $storeId)->count(),
        ];

        $recentLeads = WhatsappClick::query()
            ->where('store_id', $storeId)
            ->with('product.images')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLeads'));
    }

    protected function percentChange(int $previous, int $current): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
