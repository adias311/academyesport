@extends('layouts.backend.master')

@section('title', 'Transactions')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <x-card.card-action title="List Transactions" url="{{ route('member.transactions.index') }}">
                    <x-table.table-responsive>
                        <thead>
                            <tr>
                                <th class="w-1">#</th>
                                <th>Invoice</th>
                                <th>Email</th>
                                <th>Payment Method</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>                    
                            @foreach ($transactions as $i => $transaction)                            
                                <tr>
                                    <td class="text-muted">{{ $i + $transactions->firstItem() }}</td>
                                    <td class="text-muted">{{ $transaction->invoice }}</td>
                                    <td class="text-muted">{{ $transaction->user->email }}</td>
                                    <td class="text-muted">{{ $transaction->method_of_payment }}</td>
                                    @if (Str::contains($transaction->invoice, 'INVS'))
                                    <td class="text-muted ">
                                        @php
                                            $sub = $subsTransactions[$transaction->id] ?? null;
                                            $grandtotal = $sub->grandtotal ?? 0;
                                            $discount = $sub->discount ?? 0;
                                            $finalPrice = $grandtotal - ($grandtotal * $discount / 100);
                                        @endphp
                                        Rp. {{ number_format($finalPrice) }}
                                    </td>                                    
                                    @else
                                    <td class="text-muted ">
                                        @php
                                        $price = $transaction->details->sum('grand_total');
                                        $detail = $transaction->details->where('discount', '>', 0)->first();
                                        $disk = $detail->discount ?? 0;
                                        $finalPrice = $price - ($price * $disk / 100);
                                        @endphp
                                        Rp. {{number_format($finalPrice)}}
                                    </td>
                                    @endif                                   
                                    <td class="text-center">
                                        <span class="badge bg-{{ $transaction->status == 0 ? 'red' : 'success' }}">
                                            {{ $transaction->status == 0 ? 'Pending' : 'Success' }}
                                        </span>
                                    </td>
                                    <td class="text-muted text-center">
                                        {{ Carbon\Carbon::parse($transaction->date_transfer)->format('d F Y') }}
                                    </td>
                                    <td class="text-center">
                                        <x-button.button-link title="Details"
                                            url="{{ route('member.transactions.show', $transaction->invoice) }}"
                                            icon="file" class="btn btn-primary" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table.table-responsive>
                </x-card.card-action>
            </div>
        </div>
    </div>
@endsection
