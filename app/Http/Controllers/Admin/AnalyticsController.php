<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductView;
use App\Models\WhatsappClick;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $storeId = Auth::user()->store->id;

        $totalViews = ProductView::where('store_id', $storeId)->count();
        $totalClicks = WhatsappClick::where('store_id', $storeId)->count();
        $conversionRate = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0.0;

        $trend = $this->dailyTrend($storeId);

        $topCategories = $this->topCategories($storeId);

        $mostViewed = Product::query()
            ->where('store_id', $storeId)
            ->published()
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        $mostClicked = Product::query()
            ->where('store_id', $storeId)
            ->published()
            ->withCount('whatsappClicks')
            ->orderByDesc('whatsapp_clicks_count')
            ->limit(5)
            ->get();

        return view('admin.analytics', compact(
            'totalViews',
            'totalClicks',
            'conversionRate',
            'trend',
            'topCategories',
            'mostViewed',
            'mostClicked'
        ));
    }

    protected function dailyTrend(int $storeId): array
    {
        $start = Carbon::now()->subDays(6)->startOfDay();

        $views = ProductView::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('store_id', $storeId)
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck('total', 'day');

        $clicks = WhatsappClick::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('store_id', $storeId)
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck('total', 'day');

        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $days[] = [
                'label' => Carbon::now()->subDays($i)->format('D'),
                'views' => (int) ($views[$date] ?? 0),
                'clicks' => (int) ($clicks[$date] ?? 0),
            ];
        }

        return $days;
    }

    protected function topCategories(int $storeId): array
    {
        $rows = Category::query()
            ->withCount(['products as views_count' => function ($q) use ($storeId) {
                $q->published()
                    ->where('products.store_id', $storeId)
                    ->join('product_views', 'product_views.product_id', '=', 'products.id');
            }])
            ->get()
            ->filter(fn ($category) => $category->views_count > 0)
            ->sortByDesc('views_count')
            ->take(5);

        $total = $rows->sum('views_count');

        return $rows->map(fn ($category) => [
            'name' => $category->name,
            'count' => $category->views_count,
            'percent' => $total > 0 ? round(($category->views_count / $total) * 100) : 0,
        ])->all();
    }
}
