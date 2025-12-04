<?php

namespace App\Livewire\Reports;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReportSalesLivewire extends Component
{
    use WithPagination;

    public $startDate, $endDate, $customer_id, $user_id;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // dev by Techlink360: Initialize with the current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // dev by Techlink360: Parse dates for accurate range filtering
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // dev by Techlink360: Base query for sales
        $salesQuery = Sale::with('customer', 'creator', 'items')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // dev by Techlink360: Apply filters if they are set
        if ($this->customer_id) {
            $salesQuery->where('customer_id', $this->customer_id);
        }

        if ($this->user_id) {
            $salesQuery->where('created_by', $this->user_id);
        }

        // dev by Techlink360: Get all filtered sales for summary calculations
        $allFilteredSales = $salesQuery->get();

        // dev by Techlink360: Calculate summary data
        $totalRevenue = $allFilteredSales->sum('total_amount');
        $totalSalesCount = $allFilteredSales->count();
        $totalItemsSold = $allFilteredSales->sum(function ($sale) {
            return $sale->items->sum('quantity');
        });
        $averageSaleAmount = $totalSalesCount > 0 ? $totalRevenue / $totalSalesCount : 0;

        // dev by Techlink360: Get paginated results for the table
        $sales = $salesQuery->orderBy('created_at', 'desc')->paginate(10);

        // dev by Techlink360: Get data for filter dropdowns
        $customers = Customer::all();
        $users = User::all();

        return view('livewire.reports.report-sales-livewire', [
            'sales' => $sales,
            'customers' => $customers,
            'users' => $users,
            'totalRevenue' => $totalRevenue,
            'totalSalesCount' => $totalSalesCount,
            'totalItemsSold' => $totalItemsSold,
            'averageSaleAmount' => $averageSaleAmount,
        ]);
    }
}
