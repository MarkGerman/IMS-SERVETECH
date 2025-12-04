<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitReportExport implements FromCollection, WithHeadings
{
    protected $profitPerProduct;
    protected $profitPerSale;
    protected $totalProfit;
    protected $totalSales;
    protected $totalExpenses;

    public function __construct($profitPerProduct, $profitPerSale, $totalProfit, $totalSales, $totalExpenses)
    {
        $this->profitPerProduct = $profitPerProduct;
        $this->profitPerSale = $profitPerSale;
        $this->totalProfit = $totalProfit;
        $this->totalSales = $totalSales;
        $this->totalExpenses = $totalExpenses;
    }

    public function collection()
    {
        $data = [];

        $data[] = ['Report Summary'];
        $data[] = ['Total Sales', $this->totalSales];
        $data[] = ['Total Expenses', $this->totalExpenses];
        $data[] = ['Total Profit', $this->totalProfit];
        $data[] = []; // Spacer

        $data[] = ['Profit per Product'];
        $data[] = $this->headings()[0]; // Get headings from headings() method
        foreach ($this->profitPerProduct as $product) {
            $data[] = [
                $product->name,
                $product->total_quantity_sold,
                $product->total_revenue,
                $product->total_cost,
                $product->profit,
            ];
        }
        $data[] = []; // Spacer

        $data[] = ['Profit per Sale'];
        $data[] = $this->headings()[1]; // Get headings from headings() method
        foreach ($this->profitPerSale as $sale) {
            $data[] = [
                $sale->id,
                $sale->customer->name ?? 'N/A',
                $sale->sale_date->format('Y-m-d'),
                $sale->total_amount,
                $sale->profit,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            ['Product', 'Quantity Sold', 'Total Revenue', 'Total Cost', 'Profit'],
            ['Sale ID', 'Customer', 'Sale Date', 'Total Amount', 'Profit'],
        ];
    }
}
