@extends('layouts.frontend.master')

@section('title', 'Series')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title font-weight-bold text-uppercase">
                        All Series
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($series as $data)
            <div class="col-12 col-lg-4 apa">
                <a class="text-dark" href="{{ route('series.show', $data->slug) }}">
                    <div class="card card-stacked">
                        <div class="ribbon bg-primary {{ $data->updated_at->diffInDays(now()) <= 7 ? '' : 'invisible' }}">New</div>
                        <div class="card-body">
                            <h3 class="card-title text-truncate-1">{{ $data->name }}</h3>
                            <p class="text-muted text-truncate-2">{{ $data->description }}</p>
                            <ul class="list-unstyled">
                                @foreach ($data->tags->take(5) as $tag)
                                    <li class="badge bg-{{ $tag->color }}" style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 1);">
                                        {{ $tag->name }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $data->videos->filter(fn($video) => !str_contains($video->video_code, 'documents'))->count() }} Episode
                                </div>
                                <div>
                                    Rp. {{ number_format($data->price) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-device-desktop-analytics" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <rect x="3" y="4" width="18" height="12" rx="1"></rect>
                                        <path d="M7 20h10"></path>
                                        <path d="M9 16v4"></path>
                                        <path d="M15 16v4"></path>
                                        <path d="M9 12v-4"></path>
                                        <path d="M12 12v-1"></path>
                                        <path d="M15 12v-2"></path>
                                        <path d="M12 12v-1"></path>
                                    </svg>
                                    {{ $data->level }}
                                </div>
                                <div class="{{ $data->status == 1 ? 'text-teal' : 'text-danger' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-circle-check" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M9 12l2 2l4 -4"></path>
                                    </svg>
                                    {{ $data->status == 1 ? 'Completed' : 'Developed' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <style>

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: min-content; 
        }

        .text-truncate-1 {
            white-space: nowrap;      
            overflow: hidden;         
            text-overflow: ellipsis;  
            width: 100%;              
            display: block;           
        }
        
        .card-stacked {
            height: 280px;
        }

        .card-body {
            display: flex !important;
            flex-direction: column; 
            justify-content: space-between; 
        }

        .apa {
            margin-bottom: 1rem; 
        }
       
    </style>
@endsection
