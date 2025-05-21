<?php

namespace App\Http\Controllers;

use App\Models\Cart; 
use App\Models\Series;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Series $series)
    {
        // Ambil semua item dalam cart untuk user yang login
        $series_db = Series::where('id', $series->id)->get(); 
        // Hitung total harga
        $grandTotal = $series_db->sum('price');

        $carts = $series_db;

        return view('landing.cart.index', compact('carts', 'grandTotal'));
    }

    public function store(Series $series, Request $request)
    {
    
        // get users
        $user = Auth::user();

        // check if user has already added this series
        $alreadyInCart = Cart::where('user_id', $user->id)->where('series_id', $series->id)->first();

        // if user has already added this series
        if($alreadyInCart && $request->type == 'cart'){
            // return back with error
            return back()->with('toast_error', 'Series already in cart');
        } else if(!$alreadyInCart && $request->type == 'cart'){ 
            // create new cart
            $user->carts()->create([
                'series_id' => $series->id,
                'price' => $series->price,
            ]);
            return back()->with('toast_success', 'Series added to cart!');
        } else{            
            // return cart page
            return redirect(route('carts.index' , $series->id));
        }
    }

    public function stores(Request $request)
    {
        $id = $request->input('series_id'); // Ambil array ID dari request
    
        // Pastikan $id adalah array sebelum digunakan dalam whereIn
        if (!is_array($id)) {
            $id = [$id]; // Ubah ke array jika hanya satu ID
        }
    
        // Ambil semua series dengan ID yang ada dalam array
        $carts = Series::whereIn('id', $id)->get(); 
    
        // Hitung total harga
        $grandTotal = $carts->sum('price');
    
        return view('landing.cart.index', compact('carts', 'grandTotal'));
    }

    public function storeSubs(Request $request)
    {
    
        // get users
        $user = Auth::user();

        //subs
        $subs = Subscription::first();

        // price
        
        if ($request->rm_date != 'Expired') {
            $grandTotal = $subs->price - ($subs->price * ($subs->discount_extend / 100));
        } else {
            $grandTotal = $subs->price;
        }

        //rm_date
        $rm_date = $request->rm_date;

        return view('landing.cart.indexs' , compact('subs', 'grandTotal','rm_date' ));
       
    }
    
    public function destroy(Cart $cart)
    {
        // delete cart
        $cart->delete();

        // check if cart is not empty
        if($cart->count() >= 1){
            // return to cart page
            return back()->with('toast_success', 'Series removed from cart!');
        }else{
            // return to landing page
            return redirect(route('landing'))->with('toast_success', 'Your Cart is empty!');
        }
    }
}
