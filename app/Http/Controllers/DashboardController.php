<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate statistics
        $stats = [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalStockItems' => Product::sum('quantity'),
            'totalStockValue' => Product::sum(DB::raw('quantity * price')),
            'lowStockItems' => Product::where('quantity', '<=', 10)->count(),
            'recentMovements' => StockMovement::whereDate('created_at', today())->count(),
        ];

        // Get recent stock movements
        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Get low stock products
        $lowStockProducts = Product::where('quantity', '<=', 10)
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentMovements' => $recentMovements,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
