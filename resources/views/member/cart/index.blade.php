@extends('layouts.backend.master')

@section('title', 'Subscription')
@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">               
                <x-card.card-action title="Subscription" url="">
                    <div class="row p-3">
                        <div class="col-md-6 col-lg-3">
                            <x-utilities.widget title="Price" subTitle='Rp. {{ number_format($subs->price) }}' class="bg-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path><path d="M12 6v2m0 8v2"></path></svg>
                            </x-utilities.widget>                                                                            
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <x-utilities.widget title="Renewal Discount" subTitle="{{ $subs->discount_extend }}%" class="bg-azure">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rosette-discount"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><circle cx="9.5" cy="9.5" r=".5" fill="currentColor" /><circle cx="14.5" cy="14.5" r=".5" fill="currentColor" /><path d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7a2.2 2.2 0 0 0 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1a2.2 2.2 0 0 0 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" /></svg>
                            </x-utilities.widget>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <x-utilities.widget title="Upgrade Discount" subTitle="{{ $subs->discount_upgrade }}%" class="bg-indigo">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rosette-discount"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><circle cx="9.5" cy="9.5" r=".5" fill="currentColor" /><circle cx="14.5" cy="14.5" r=".5" fill="currentColor" /><path d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7a2.2 2.2 0 0 0 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1a2.2 2.2 0 0 0 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" /></svg>
                            </x-utilities.widget>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <x-utilities.widget title="Additional Days" subTitle="{{ $subs->extra_days }} days" class="bg-danger">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                            </x-utilities.widget>
                        </div>
                    </div>
                    <x-button.button-save title="Edit Subscription" icon="edit" class="btn btn-primary mr-3 mb-3 float-right" data-toggle="modal" data-target="#modal-simple1"/>
                </x-card.card-action>               
            </div>
        </div>
    </div>

    <x-modal.modal title="Edit Subscription" id="1">
        <form action="{{ route('member.cart.update', $subs->id) }}" method="POST">
        @csrf
        @method('PUT')                                
        <x-form.input type="text" title="Subscription Price ( Rp )" name="price" placeholder=""
            value="{{ $subs->price }}" />                                
        <x-form.input type="text" title="Renewal Discount ( % )" name="renewal" placeholder=""
            value="{{ $subs->discount_extend }}" />                                
        <x-form.input type="text" title="Upgrade Discount ( % )" name="upgrade" placeholder=""
            value="{{ $subs->discount_upgrade }}" />                                
        <x-form.input type="text" title="Additional Days" name="days" placeholder=""
            value="{{ $subs->extra_days }}" />                                
        <x-button.button-save title="Save" icon="save" class="btn btn-primary" />
        </form>
    </x-modal.modal>

    <script>
        document.getElementsByClassName("input-icon")[0].classList.add("invisible");       
    </script>
@endsection
