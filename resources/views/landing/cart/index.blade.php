@extends('layouts.frontend.master')

@section('title', 'Carts')

@php
    use App\Models\UserSub;
    $subs = UserSub::where('user_id', auth()->id())->with('subscription')->first();
    $subs1 = $subs ? $subs->subscription : "";
    $dis_up = $subs ? $grandTotal - ($grandTotal * $subs1->discount_upgrade / 100) : $grandTotal;
@endphp

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info " role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    Please transfer first before you confirm your payment.
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div style="position: sticky; top: 0;">
                    <x-card.card title="All Transactions">
                        <div class="list-group">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-uppercase">Mandiri</h3>
                                    <div>
                                        <h4>43231230xx</h4>
                                    </div>
                                </div>
                                <div class="avatar">
                                    <img src="{{ asset('dist/img/payments/livin.png') }}" />
                                </div>
                            </div>
                            <hr class="mt-2 mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-uppercase">Gopay</h3>
                                    <div>
                                        <h4>082251415053</h4>
                                    </div>
                                </div>
                                <span class="avatar">
                                    <img src="{{ asset('dist/img/payments/gopay.png') }}" />
                                </span>
                            </div>
                            <hr class="mt-2 mb-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-uppercase">Ovo</h3>
                                    <div>
                                        <h4>082251415053</h4>
                                    </div>
                                </div>
                                <span class="avatar">
                                    <img src="{{ asset('dist/img/payments/ovo.png') }}" />
                                </span>
                            </div>
                        </div>
                    </x-card.card>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <x-card.card title="Detail Items" class="p-0">
                    <x-table.table-responsive>
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 1%"></th>
                                <th>Series Name</th>
                                <th class="text-end" style="">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                            @if(isset($cart->series->name)) 
                            <tr>
                                <td>
                                    {{-- <x-button.button-delete id="{{ $cart->id }}"
                                        url="{{ route('carts.destroy', $cart->id) }}" title="" /> --}}
                                <td>
                                    <p class="strong mb-1">{{ $cart->series->name }}</p>
                                </td>
                                <td class="text-end">
                                    <div class="text-dark">
                                        Rp. {{ number_format($cart->price) }}
                                    </div>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>
                                    {{-- <x-button.button-delete id="{{ $cart->id }}"
                                        url="{{ route('carts.destroy', $cart->id) }}" title="" /> --}}
                                <td>
                                    <p class="strong mb-1">{{ $cart->name }}</p>
                                </td>
                                <td class="text-end">
                                    <div class="text-dark">
                                        Rp. {{ number_format($cart->price) }}
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach

                           @if ($subs != null)
                           <tr>
                            <td colspan="2" class="font-weight-bold text-end">
                                Upgrade Discount                                
                            </td>
                            <td class="font-weight-bold text-end text-primary">
                                {{$subs1->discount_upgrade}}%
                            </td>
                        </tr>                               
                           @endif
                            <tr>
                                <td colspan="2" class="font-weight-bold text-uppercase text-end">
                                    Grand Total
                                </td>
                                <td class="font-weight-bold text-end text-primary">
                                    Rp {{ number_format($dis_up) }}
                                </td>
                            </tr>
                        </tbody>
                    </x-table.table-responsive>
                </x-card.card>
                <x-card.card title="Payment Confirmation">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <input type="number" name="diskon_upgrade" value="{{ $subs1->discount_upgrade }}" hidden>
                        <x-form.input title="Full Name" name="name_of_bank" value="{{ auth()->user()->name }}" placeholder=""
                            type="text" readonly/>
                        <x-form.input title="Source Payment Account" name="bank_transfer" value="" placeholder="e.g. BCA - 1234567890 (John Doe), GoPay - 081234567890 (John Doe)" type="text" required />
                        <x-form.select title="Payment Method" name="method_of_payment">
                            <option value="mandiri">Mandiri</option>
                            <option value="gopay">Gopay</option>
                            <option value="ovo">Ovo</option>
                        </x-form.select>
                        <x-form.input 
                            title="Date Transfer" 
                            name="date_transfer" 
                            value="{{ now()->toDateString() }}" 
                            type="date" 
                            readonly 
                            onfocus="this.blur()"
                            placeholder=""
                        />
                        <x-form.input title="Total Price" name="" value="Rp. {{ number_format($grandTotal) }}"
                            placeholder="" type="text" disabled />
                            @foreach ($carts as $cart)
                                @if (isset($cart->series->name))
                                    <input readonly type="hidden" name="series_id[]" value="{{ $cart->series->id }}">
                                    <input readonly type="hidden" name="price[]" value="{{ $cart->series->price }}">
                                @else
                                    <input readonly type="hidden" name="series_id[]" value="{{ $cart->id }}">
                                    <input readonly type="hidden" name="price[]" value="{{ $cart->price }}">
                                @endif
                            @endforeach
                        <x-button.button-save icon="check" title="Confirmation"
                            class="btn btn-primary w-full font-weight-bold text-uppercase" />
                    </form>
                </x-card.card>
            </div>            
        </div>
    </div>
@endsection
