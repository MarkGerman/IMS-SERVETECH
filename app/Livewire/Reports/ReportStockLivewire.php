<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Native\Desktop\Facades\Window;
use Native\Desktop\Facades\System;
use Native\Desktop\Facades\Printer;
use Illuminate\Support\Facades\Storage;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class ReportStockLivewire extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $sortBy = 'name';
    public $sortDir = 'ASC';

    public $modal = false;

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortDir == 'ASC') {
            $this->sortDir = 'DESC';
        } else {
            $this->sortDir = 'ASC';
        }
        $this->sortBy = $field;
    }


    public function cancel(){
        $this->reset(['modal']);
    }


    public function printPage()
    {
        $this->modal = true;
        $pdf =  System::printToPDF('<!DOCTYPE html>
                                        <html lang="en">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                <title>Document</title>
                                            </head>
                                            <body>
                                                hello
                                            </body>
                                        </html>');

        Storage::disk('custom')->put('My Awesome File.pdf', base64_decode($pdf));
        // dd($pdf);    

        $this->alert('success', 'done');



        //     $system = new System();
        //  dd($system);


    }

    public function render()
    {
        $query = Product::with('category')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });

        $allProducts = $query->get();

        $totalProducts = $allProducts->count();
        $totalQuantity = $allProducts->sum('quantity');
        $totalPurchaseValue = $allProducts->sum(function ($product) {
            return $product->purchase_price * $product->quantity;
        });
        $totalSellingValue = $allProducts->sum(function ($product) {
            return $product->selling_price * $product->quantity;
        });
        $lowStockProducts = $allProducts->where('quantity', '<=', 'reorder_level')->count();


        $products = $query->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);

        return view('livewire.reports.report-stock-livewire', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalQuantity' => $totalQuantity,
            'totalPurchaseValue' => $totalPurchaseValue,
            'totalSellingValue' => $totalSellingValue,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
