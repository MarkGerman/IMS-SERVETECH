<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customers;
use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardLivewire extends Component
{
    // Auto-refresh every 60 seconds handled in Blade with wire:poll.60s

    public function getTotalSalesTodayProperty()
    {
        return (float) Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');
    }

    public function getProductsInStockProperty()
    {
        return (int) Product::sum('quantity');
    }

    public function getProfitTodayProperty()
    {
        // Sum of (unit_price - purchase_price) * quantity for today's sales
        $profit = SaleItem::selectRaw('SUM((sale_items.unit_price - products.purchase_price) * sale_items.quantity) as profit')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.sale_date', Carbon::today())
            ->value('profit');

        return (float) ($profit ?? 0);
    }

    public function getLowStockCountProperty()
    {
        return (int) Product::whereRaw('quantity <= reorder_level')->count();
    }

    public function getSalesChartDataProperty()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M j');
            $total = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $data[] = (float) $total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    public function getBestSellingProductsProperty()
    {
        return SaleItem::select('products.id', 'products.name', DB::raw('SUM(sale_items.quantity) as units_sold'), DB::raw('SUM(sale_items.total_price) as revenue'))
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units_sold')
            ->limit(5)
            ->get();
    }

    public function getRecentTransactionsProperty()
    {
        return Sale::with(['customer', 'creator'])
            ->orderByDesc('sale_date')
            ->limit(5)
            ->get();
    }

    public function getLowStockItemsProperty()
    {
        return Product::whereRaw('quantity <= reorder_level')
            ->orderBy('quantity')
            ->get();
    }

    public function getExpenseTodayProperty()
    {
        return (float) Expense::whereDate('expense_date', Carbon::today())->sum('amount');
    }

    private function fmt($amount)
    {
        return $amount === null ? '—' : 'MWK ' . number_format((float) $amount, 0, '.', ',');
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-livewire', [
            'totalSalesToday' => $this->totalSalesToday,
            'productsInStock' => $this->productsInStock,
            'profitToday' => $this->profitToday,
            'lowStockCount' => $this->lowStockCount,
            'salesChartData' => $this->salesChartData,
            'bestSellingProducts' => $this->bestSellingProducts,
            'recentTransactions' => $this->recentTransactions,
            'lowStockItems' => $this->lowStockItems,
            'expenseToday' => $this->expenseToday,
        ]);
    }
}
