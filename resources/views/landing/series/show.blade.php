@extends('layouts.frontend.master')

@section('title')
    {{ $series->name }}
@endsection
 
@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12 col-lg-12">
                <x-card.card-description>
                    <div class="row">
                        <div class="col-md-5 order-1 order-md-2 mb-md-0 mb-3">
                            <img src="{{ $series->cover }}" class="img-fluid" />
                        </div>
                        <div class="col-md-7 col-12 order-2 order-md-1">
                            <div class="ribbon bg-red">Rp. {{ number_format($series->price) }}</div>
                            <h3 class="card-title">{{ $series->name }}</h3>
                            <p class="card-text">{{ $series->description }}</p>
                            <ul class="list-unstyled">
                                @foreach ($series->tags as $tag)
                                    <li class="badge bg-{{ $tag->color }}" style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 1);">
                                        {{ $tag->name }}
                                    </li>
                                @endforeach
                            </ul>
                            <x-utilities.item date="{{ $series->created_at->format('d F Y') }}"
                                level="{{ $series->level }}"
                                status="{{ $series->status == 1 ? 'Compeleted' : 'Developed' }}"
                                episode="{{ $series->videos->filter(fn($video) => !str_contains($video->video_code, 'documents'))->count() }} Episode" 
                                members="{{ $members }} Members" />
                            <div class="mt-2 d-flex">
                                @if (isset($transaction->status))
                                    @if($transaction->status)
                                    <div class="alert alert-success" role="alert">
                                        <i class="fas fa-user-check mr-1"></i>
                                        Licensed to : {{ Auth::user()->name }} ({{ Auth::user()->email }}) — 
                                        {{ Carbon\Carbon::parse($transaction->date_transfer)->format('d F Y') }}
                                    </div>
                                    @else
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fas fa-user-check mr-1"></i>
                                        Pending : {{ Auth::user()->name }} ({{ Auth::user()->email }}) — 
                                        {{ Carbon\Carbon::parse($transaction->date_transfer)->format('d F Y') }}
                                    </div>
                                    @endif
                                @else
                                <form action="{{ route('carts.store', $series->slug) }}" method="POST">
                                    @csrf
                                    <x-button.button-save icon="money-bill" title="Purchase"
                                        class="btn btn-outline-primary" />
                                </form>                         
                                {{-- @role('member')
                                <form class="ml-2" action="{{ route('carts.store', $series->slug) }}" method="POST">
                                    @csrf
                                    <x-button.button-save icon="shopping-cart" title="Add to Cart"
                                        class="btn btn-outline-danger" name="type" value="cart" />
                                </form>
                                @endrole --}}
                                @endif                                      
                            </div>                            
                        </div>
                        
                    </div>
                </x-card.card-description>
            </div>
            <div class="col-12">
                <x-card.card title="Playlists - {{ $series->name }}">
                    <div class="list-group list-group-flush">
                        @forelse($videos->reject(fn($video) => str_contains($video->video_code, 'document')) as $i => $video)
                            <a href="{{ route('series.video', [$series->slug, $video->episode]) }}"
                                class="list-group-item list-group-item-action" aria-current="true">
                                Eps {{ $video->episode }} - {{ $video->name }}
                                <span class="badge bg-{{ $video->intro == 1 ? 'azure' : 'red' }} ml-1">
                                    {{ $video->intro == 1 ? 'free' : 'pro' }}
                                </span>
                            </a>
                        @empty
                            {{-- <x-alert.alert-danger title="This Series don't have any video"/> --}}
                            <h4 class="text-center text-danger">This Series don't have any video</h4>
                        @endforelse                         
                    </div>
                </x-card.card>
            </div>
            <div class="col-12">
                <x-card.card title="Documents - {{ $series->name }}">
                    <div class="list-group list-group-flush">
                        @forelse($videos->filter(fn($video) => str_contains($video->video_code, 'document')) as $i => $video)
                        <a href="{{ route('series.document', [$series->slug, $video->episode]) }}"                                class="list-group-item list-group-item-action" aria-current="true">
                                Chapter {{ $video->episode }} - {{ $video->name }}
                                <span class="badge bg-{{ $video->intro == 1 ? 'azure' : 'red' }} ml-1">
                                    {{ $video->intro == 1 ? 'free' : 'pro' }}
                                </span>
                            </a>
                        @empty
                            <h4 class="text-center text-danger">This Series don't have any document</h4>
                        @endforelse                       
                    </div>
                </x-card.card>
            </div>
        </div>
    </div>
@endsection
