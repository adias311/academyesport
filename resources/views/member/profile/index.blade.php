@extends('layouts.backend.master')

@section('title', 'Profile')

@section('content')
    <div class="container-xl">
        <div class="row">
           @if($plan != "")

           <div class="col-12">
            <div class="alert alert-success" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle mr-1"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Get a {{ $subs->discount_extend}}% discount on the subscription price by renewing before your subscription expires.            
            </div>
           </div>

            <div class="col-12">
                <x-card.card title="Subscription Details">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-1 border pt-2">
                            <strong>Level</strong>
                            <p class="mt-2">{{$plan}}</p>
                        </div>
                        <div class="col-md-4 mb-1 border pt-2">
                            <strong>Remaining</strong>
                            <p class="mt-2">{{$rm_date}}</p>
                        </div>
                        <div class="col-md-4 mb-1 border pt-2">
                            <strong>Price</strong>
                            <p class="mt-2">Rp {{ number_format($subs->price)}}</p>
                        </div>
                    </div>
                    <form action="{{ route('carts.store.subs') }}" method="POST" enctype="multipart/form-data">
                        @csrf     
                        <input type="hidden" name="rm_date" value="{{$rm_date}}">                                      
                        <x-button.button-save icon="tag" title="Renew Subscription" class="btn btn-warning" />
                    </form>
                </x-card.card>
            </div>
           @endif
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <x-card.card title="Account Details">
                    <form action="{{ route('member.profile.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <x-form.input title="Name" name="name" value="{{ $user->name }}" placeholder=""
                                    type="text" />
                            </div>
                            <div class="col-6">
                                <x-form.input title="Email" name="email" value="{{ $user->email }}" placeholder=""
                                    type="email" />
                            </div>
                        </div>
                        <x-form.input title="Avatar" name="avatar" value="{{ $user->avatar }}" placeholder=""
                            type="file" />
                        <x-button.button-save icon="user" title="Update Profile" class="btn btn-primary" />
                    </form>
                </x-card.card>
            </div>
            <div class="col-12 col-md-6">
                <x-card.card title="Update Password">
                    <form action="{{ route('member.profile.updatePassword', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <x-form.input title="Current Password" name="current_password" value=""
                                placeholder="Input your password" type="password" />
                            <div class="col-6">
                                <x-form.input title="New Password" name="password" value="" placeholder="Input new password"
                                    type="password" />
                            </div>
                            <div class="col-6">
                                <x-form.input title="Password Confirmation" name="password_confirmation" value=""
                                    placeholder="Input password confirmation" type="password" />
                            </div>
                        </div>
                        <x-button.button-save icon="lock" title="Update Password" class="btn btn-danger" />
                    </form>
                </x-card.card>
            </div>
        </div>
    </div>
@endsection
