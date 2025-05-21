<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Series;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TransactionSub;
use App\Traits\HasSeries;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use HasSeries;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // count all transactions where status false
        $transactionVerified = Transaction::where('status', false)->count();
        // count all users where role is member
        try {
            $members = User::role('member')->count();
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            $members = 0;
        }
        // count all series
        $series = Series::count();

        // sum all transaction
        $profits_ser = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('status', 1);
        })->get()->reduce(function ($carry, $item) {
            // Jika ada diskon, hitung grand_total setelah diskon
            $total = $item->discount > 0
                ? $item->grand_total * (1 - $item->discount / 100)
                : $item->grand_total;
    
            return $carry + $total;
        }, 0);

        $profits_sub = TransactionSub::whereHas('transaction', function ($query) {
            $query->where('status', 1);
        })->get()->reduce(function ($carry, $item) {
            // Jika ada diskon, hitung grand_total setelah diskon
            $total = $item->discount > 0
                ? $item->grandtotal * (1 - $item->discount / 100)
                : $item->grandtotal;
    
            return $carry + $total;
        }, 0);

        $profits = $profits_ser + $profits_sub;

        // call method bestSeries from Trait HasSeries
        $bestSeries = $this->bestSeries();

        // return view
        return view('admin.dashboard', compact('transactionVerified', 'members', 'series', 'profits', 'bestSeries'));
    }
}
