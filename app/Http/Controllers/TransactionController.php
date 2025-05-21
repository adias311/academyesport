<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Series;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionSub;
use App\Models\UserSub;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // define variables
        $length = 10;
        $random = '';
        // do loop until $i have 10 character
        for($i = 0; $i < $length; $i++){
            // get random character from string and number
            $random .= rand(0,1) ? rand(0,9) : chr(rand(ord('a'), ord('z')));
        }
        // get invoice code
        $invoice = 'INV-'.Str::upper($random);

        // create new transaction
        $transaction = Transaction::create([
            'invoice' => $invoice,
            'name_of_bank' => $request->name_of_bank,
            'user_id' => Auth::id(),
            'bank_transfer' => $request->bank_transfer,
            'method_of_payment' => $request->method_of_payment,
            'date_transfer' => $request->date_transfer,
            'status' => false,
        ]);

        $price = $request->input('price');

        // if level and create user_subs
        $seri = Series::where('id', $request->input('series_id')[0])->first(); 
        $req_series_id = $request->input('series_id');

        $user_seriDb = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 1);
        })->get();

        if ($seri->slug && strpos($seri->slug, 'intermediate') !== false) {
            if(!$user_seriDb->count() > 0) {
                array_push($req_series_id, 1);
            }                     
        } else if ($seri->slug && strpos($seri->slug, 'advanced') !== false) {
            if($user_seriDb->count() <= 0) {
                array_push($req_series_id, 1);
                array_push($req_series_id, 2);
            } elseif($user_seriDb->count() == 1) {
                array_push($req_series_id, 2);
            }       
        }        

        // create new transaction detail
        foreach ($req_series_id as $index => $series_id) {
            if($price[$index] == 0) {
                $disk = 0;
            } else {
                $disk = $request->diskon_upgrade;
            }
            $transaction->details()->create([
                'transaction_id' => $transaction->id,
                'series_id' => $series_id,
                'grand_total' => $price[$index] ?? 0,
                'discount' => $disk  
            ]);

            // delete all cart by user
            Cart::where('user_id', Auth::id())->where('series_id', $series_id)->delete();
        }        

        // return to landing page
        return redirect(route('landing'))->with('success', 'Thank you for your purchase!');
    }

    public function store_subs(Request $request)
    {

        // define variables
        $length = 10;
        $random = '';
        // do loop until $i have 10 character
        for($i = 0; $i < $length; $i++){
            // get random character from string and number
            $random .= rand(0,1) ? rand(0,9) : chr(rand(ord('a'), ord('z')));
        }
        // get invoice code
        $invoice = 'INVS-'.Str::upper($random);

        // create new transaction
        $transaction = Transaction::create([
            'invoice' => $invoice,
            'name_of_bank' => $request->name_of_bank,
            'user_id' => Auth::id(),
            'bank_transfer' => $request->bank_transfer,
            'method_of_payment' => $request->method_of_payment,
            'date_transfer' => $request->date_transfer,
            'status' => false,
        ]);        

        // create new transaction subs
        TransactionSub::create([
            'transaction_id' => $transaction->id,
            'grandtotal' => $request->price,
            'discount' => $request->discount
        ]);

        return redirect(route('member.profile.index'))->with('success', 'Thank you for your purchase!');
    }


    // public function store(Request $request)
    // {
    //     // define variables
    //     $length = 10;
    //     $random = '';
    //     // do loop until $i have 10 character
    //     for($i = 0; $i < $length; $i++){
    //         // get random character from string and number
    //         $random .= rand(0,1) ? rand(0,9) : chr(rand(ord('a'), ord('z')));
    //     }
    //     // get invoice code
    //     $invoice = 'INV-'.Str::upper($random);

    //     // create new transaction
    //     $transaction = Transaction::create([
    //         'invoice' => $invoice,
    //         'name_of_bank' => $request->name_of_bank,
    //         'user_id' => Auth::id(),
    //         'bank_transfer' => $request->bank_transfer,
    //         'method_of_payment' => $request->method_of_payment,
    //         'date_transfer' => $request->date_transfer,
    //         'status' => false,
    //     ]);

    //     // get cart by user
    //     $carts = Cart::where('user_id', Auth::id())->get();

    //     // looping carts
    //     foreach($carts as $cart){
    //         // create new transaction detail
    //         $transaction->details()->create([
    //             'transaction_id' => $transaction->id,
    //             'series_id' => $cart->series_id,
    //             'grand_total' => $cart->price,
    //         ]);
    //     }

    //     // delete all cart by user
    //     Cart::where('user_id', Auth::id())->delete();

    //     // return to landing page
    //     return redirect(route('landing'))->with('success', 'Thank you for your purchase!');
    // }
}
