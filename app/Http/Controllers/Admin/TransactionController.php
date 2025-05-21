<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\TransactionSub;
use App\Models\UserSub;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all transactions
        $transactions = Transaction::with('details')->search('status')->latest()->paginate(10);
        // return view
        return view('admin.transaction.index', compact('transactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        // update transaction
        $transaction->update([
            'status' => 1
        ]); 

        // create user_subs
        $userSub = UserSub::where('user_id', $transaction->user_id)->first();
        $subs_days = Subscription::first()->extra_days;

        if ($userSub) {
            if ($userSub->remain_date->greaterThanOrEqualTo(now())) {
                // Langganan masih aktif, extend dari remain_date
                $remainDate = $userSub->remain_date->copy()->addDays($subs_days);
            } else {
                // Langganan sudah kedaluwarsa, mulai dari sekarang
                $remainDate = now()->addDays($subs_days);
            }
        } else {
            // Belum pernah subscribe
            $remainDate = now()->addDays($subs_days);
        }
        
        UserSub::updateOrCreate(
            ['user_id' => $transaction->user_id],
            [
                'subscription_id' => 1,
                'remain_date' => $remainDate,
            ]
        );        

        // return back with toastr
        return back()->with('toast_success', 'Transaction has been verified');
    }

    public function show($invoice)
    {
        // get transaction by user id and invoice
        $transaction = Transaction::where('invoice', $invoice)->first();

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
