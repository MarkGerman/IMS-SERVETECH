<?php

namespace App\Http\Controllers;

use App\Models\Returns;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function print($id)
    {
        $return = Returns::with('sale.customer', 'creator', 'approver', 'returnItems.saleItem.product')->find($id);
        return view('returns.print', compact('return'));
    }
}