<?php

namespace App\Http\Controllers\Member;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\TransactionDetail;
use App\Models\TransactionSub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        // get user logged in
        $user = Auth::id();

       // Get transactions by user ID, with eager loading of details
       $transactions = Transaction::with('details.series', 'user')
        ->where('user_id', $user)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        // Prepare an array to hold sub-transactions
        $subsTransactions = [];

        // Fetch sub-transactions for each transaction
        $subsTransactions = [];
        foreach ($transactions as $transaction) {
            $subsTransactions[$transaction->id] = TransactionSub::where('transaction_id', $transaction->id)->first();
        }
        
        // return to view
        return view('member.transaction.index', compact('transactions' , 'subsTransactions'));
    }

    public function show($invoice)
    {
        // get user logged in
        $user = Auth::id();

        // get transaction by user id and invoice
        $transaction = Transaction::with('user')->where('user_id', $user)
        ->where('invoice', $invoice)->first();

        if (Str::contains($invoice, 'INVS')) {

            $subs = Subscription::first();

            $transactionSubs = TransactionSub::where('transaction_id', $transaction->id)->first();

            $grandTotal = $transactionSubs->grandtotal - ($transactionSubs->grandtotal * $transactionSubs->discount / 100);

            return view('member.transaction.show', compact('transaction', 'transactionSubs' , 'grandTotal' , 'subs'));  
        } else {
    
            // get all transaction detail by transaction id
            $transactionDetails = TransactionDetail::where('transaction_id', $transaction->id)->get();
    
            // sum grand total from transaction detail
            $grandTotal = $transactionDetails->sum('grand_total');
    
            // return to view
            return view('member.transaction.show', compact('transaction', 'transactionDetails', 'grandTotal'));
        }

    }
}
