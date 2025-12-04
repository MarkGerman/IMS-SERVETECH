<?php

namespace App\Livewire\Reports;

use App\Models\Expense;
use App\Models\Sale;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReportProfitLivewire extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // dev by Techlink360: Initialize with the current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // dev by Techlink360: Parse dates and add time for accurate range filtering
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // dev by Techlink360: Get all sales within the date range to calculate totals
        $allSales = Sale::with('items.product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // dev by Techlink360: Calculate total revenue and cost of goods sold (COGS)
        $totalRevenue = $allSales->sum(function ($sale) {
            return $sale->items->sum(function ($item) {
                return $item->unit_price * $item->quantity;
            });
        });

        $totalCOGS = $allSales->sum(function ($sale) {
            return $sale->items->sum(function ($item) {
                // dev by Techlink360: Ensure product and purchase_price exist to avoid errors
                if ($item->product) {
                    return $item->product->purchase_price * $item->quantity;
                }
                return 0;
            });
        });

        // dev by Techlink360: Calculate gross profit
        $grossProfit = $totalRevenue - $totalCOGS;

        // dev by Techlink360: Get total expenses within the date range
        $totalExpenses = Expense::whereBetween('created_at', [$startDate, $endDate])->sum('amount');

        // dev by Techlink360: Calculate net profit
        $netProfit = $grossProfit - $totalExpenses;

        // dev by Techlink360: Get paginated sales for the table display
        $sales = Sale::with('items.product', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.reports.report-profit-livewire', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalCOGS' => $totalCOGS,
            'grossProfit' => $grossProfit,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
        ]);
    }
}
