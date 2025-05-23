@extends('layouts.backend.master')

@section('title', 'Transaction Details')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <x-card.card title="Detail Transactions" class="p-0">
                    <x-table.table-responsive>
                        <thead>
                            <tr>
                                <th>No.Invoice</th>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>{{ $transaction->invoice }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->bank_transfer }}</td>
                            <td>
                                <span class="badge bg-{{ $transaction->status == 0 ? 'red' : 'success' }}">
                                    {{ $transaction->status == 0 ? 'Pending' : 'Success' }}
                                </span>
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($transaction->date_transfer)->format('d F Y') }}
                            </td>
                        </tbody>
                    </x-table.table-responsive>
                </x-card.card>
            </div>
            <div class="col-12">
                <x-card.card title="Detail Items" class="p-0">
                    <x-table.table-responsive>
                        <thead>
                            <tr>
                                <th>Series Name</th>
                                <th class="text-right" style="">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if (isset($transactionDetails))
                         @foreach ($transactionDetails as $detail)
                            @if($detail->grand_total > 0)
                             <tr>
                                 <td>
                                     <p class="strong mb-1">{{ $detail->series->name }}</p>
                                 </td>
                                 <td class="text-right">
                                     <div class="text-dark">
                                         Rp. {{ number_format($detail->series->price) }}
                                     </div>
                                 </td>
                                 </tr> 
                            @endif  
                            @php
                                if ($detail->discount > 0) {
                                    $grandTotal = $detail->grand_total - ($detail->grand_total * $detail->discount / 100);
                                }
                            @endphp
                            @if ($detail->discount > 0)                            
                            <tr>
                                <td>
                                    <p class="strong mb-1">Upgrade Discount</p>
                                </td>
                                <td class="text-right">
                                    <div class="font-weight-bold text-right text-primary">
                                        {{ $detail->discount }}%
                                    </div>
                                </td>
                            </tr> 
                            @endif                             
                         @endforeach
                         @else
                            <tr>
                                <td>
                                    <p class="strong mb-1">Subscription Renewal ( {{ $subs->extra_days }} days )</p>
                                </td>
                                <td class="text-right">
                                    <div class="text-dark">
                                        Rp. {{ number_format($transactionSubs->grandtotal) }}
                                    </div>
                                </td>
                            </tr> 
                            @if ($transactionSubs->discount > 0)
                            <tr>
                                <td class="font-weight-bold text-end">
                                    Subscription Renewal Discount
                                </td>
                                <td class="font-weight-bold text-right text-primary">
                                    {{$transactionSubs->discount}}%
                                </td>
                            </tr>   
                            @endif
                        @endif                        
                        <tr>
                            <td class="font-weight-bold text-uppercase text-end">
                                Grand Total
                            </td>
                            <td class="font-weight-bold text-right   text-primary">
                                Rp. {{ number_format($grandTotal) }}
                            </td>
                        </tr>
                        </tbody>
                    </x-table.table-responsive>
                </x-card.card>
            </div>
        </div>
    </div> 
@endsection
