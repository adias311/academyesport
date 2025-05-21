@extends('layouts.frontend.master')

@section('title', 'Carts')

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
                                <th>Item</th>
                                <th class="text-end" style="">Price</th>
                            </tr>
                        </thead>
                        <tbody>   
                            <tr>
                                <td>
                                    {{-- <x-button.button-delete id="{{ $cart->id }}"
                                        url="{{ route('carts.destroy', $cart->id) }}" title="" /> --}}
                                <td>
                                    <p class="strong mb-1">Subscription Renewal ({{$subs->extra_days}} days)</p>
                                </td>
                                <td class="text-end">
                                    <div class="text-dark">
                                        Rp {{ number_format($subs->price) }}
                                    </div>
                                </td>
                            </tr>   
                            @if ($rm_date != 'Expired')
                            <tr>
                                <td colspan="2" class="font-weight-bold text-end">
                                    Subscription Renewal Discount
                                </td>
                                <td class="font-weight-bold text-end text-primary">
                                    {{ $subs->discount_extend }}%
                                </td>   
                            </tr>
                            @endif                      
                            <tr>
                                <td colspan="2" class="font-weight-bold text-uppercase text-end">
                                    Grand Total
                                </td>
                                <td class="font-weight-bold text-end text-primary">
                                    Rp {{ number_format($grandTotal) }}
                                </td>
                            </tr>
                        </tbody>
                    </x-table.table-responsive>
                </x-card.card>
                <x-card.card title="Payment Confirmation">
                    <form action="{{ route('transactions.store.subs') }}" method="POST">
                        @csrf
                        <input type="hidden" name="price" value="{{ $subs->price }}">
                        @php
                         if ($rm_date == 'Expired') {
                            $diskon = 0;
                         } else {
                            $diskon = $subs->discount_extend;
                         }   
                        @endphp
                        <input type="hidden" name="discount" value="{{ $diskon }} ">
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
                        <x-form.input title="Total Price" name="" value="Rp {{ number_format($grandTotal)}} "
                            placeholder="" type="text" disabled />                           
                        <x-button.button-save icon="check" title="Confirmation"
                            class="btn btn-primary w-full font-weight-bold text-uppercase" />
                    </form>
                </x-card.card>
            </div>            
        </div>
    </div>
@endsection
