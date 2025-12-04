<?php

namespace App\Livewire\Dashboard;

use Jantinnerezo\LivewireAlert\LivewireAlert;

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
    // dev by Techlink360: Public properties for the view
    public $totalSalesToday = 0;
    public $productsInStock = 0;
    public $profitToday = 0;
    public $lowStockCount = 0;
    public $bestSellingProducts;
    public $recentTransactions;
    public $lowStockItems;
    public $expenseToday = 0;

    // dev by Techlink360: Chart data properties
    public $salesChartDataToday = ['labels' => [], 'data' => []];
    public $salesChartDataWeek = ['labels' => [], 'data' => []];
    public $salesChartDataMonth = ['labels' => [], 'data' => []];

    public function mount()
    {
        $this->refreshData();
    }

    /**
     * dev by Techlink360: Refresh dashboard data.
     */
    protected function refreshData()
    {
        // dev by Techlink360: Total sales today
        $this->totalSalesToday = (float) Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');

        // dev by Techlink360: Products in stock
        $this->productsInStock = (int) Product::sum('quantity');

        // dev by Techlink360: Profit today
        $profit = SaleItem::selectRaw('SUM((sale_items.unit_price - products.purchase_price) * sale_items.quantity) as profit')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sales.sale_date', Carbon::today())
            ->value('profit');
        $this->profitToday = (float) ($profit ?? 0);

        // dev by Techlink360: Low stock count and items
        $this->lowStockCount = (int) Product::whereRaw('quantity <= reorder_level')->count();
        $this->lowStockItems = Product::whereRaw('quantity <= reorder_level')->orderBy('quantity')->get();

        // dev by Techlink360: Sales chart data for Today
        $labelsToday = [];
        $dataToday = [];
        $labelsToday[] = Carbon::today()->format('M j');
        $totalToday = Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');
        $dataToday[] = (float) $totalToday;
        $this->salesChartDataToday = ['labels' => $labelsToday, 'data' => $dataToday];

        // dev by Techlink360: Sales chart data for This Week
        $labelsWeek = [];
        $dataWeek = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labelsWeek[] = $date->format('M j');
            $total = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $dataWeek[] = (float) $total;
        }
        $this->salesChartDataWeek = ['labels' => $labelsWeek, 'data' => $dataWeek];

        // dev by Techlink360: Sales chart data for This Month
        $labelsMonth = [];
        $dataMonth = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labelsMonth[] = $date->format('M j');
            $total = Sale::whereDate('sale_date', $date)->sum('total_amount');
            $dataMonth[] = (float) $total;
        }
        $this->salesChartDataMonth = ['labels' => $labelsMonth, 'data' => $dataMonth];

        // dev by Techlink360: Best selling products
        $this->bestSellingProducts = SaleItem::select('products.id', 'products.name', DB::raw('SUM(sale_items.quantity) as units_sold'), DB::raw('SUM(sale_items.total_price) as revenue'))
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units_sold')
            ->limit(5)
            ->get();

        // dev by Techlink360: Recent transactions
        $this->recentTransactions = Sale::with(['customer', 'creator'])->orderByDesc('sale_date')->limit(5)->get();

        // dev by Techlink360: Today's expenses
        $this->expenseToday = (float) Expense::whereDate('expense_date', Carbon::today())->sum('amount');
    }

    private function fmt($amount)
    {
        return $amount === null ? '—' : 'MWK ' . number_format((float) $amount, 0, '.', ',');
    }

    public function render()
    {
        // dev by Techlink360: Refresh data on each render to ensure live updates via wire:poll
        $this->refreshData();

        return view('livewire.dashboard.dashboard-livewire', [
            'totalSalesToday' => $this->totalSalesToday,
            'productsInStock' => $this->productsInStock,
            'profitToday' => $this->profitToday,
            'lowStockCount' => $this->lowStockCount,
            'salesChartDataToday' => $this->salesChartDataToday,
            'salesChartDataWeek' => $this->salesChartDataWeek,
            'salesChartDataMonth' => $this->salesChartDataMonth,
            'bestSellingProducts' => $this->bestSellingProducts,
            'recentTransactions' => $this->recentTransactions,
            'lowStockItems' => $this->lowStockItems,
            'expenseToday' => $this->expenseToday,
        ]);
    }
}