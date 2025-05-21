@extends('layouts.frontend.master')

@section('title')
    {{ $series->name }}
@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <x-card.card title="Eps {{ $video->episode }} : {{ $video->name }}">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video->video_code }}"
                            frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                </x-card.card>
            </div>
            <div class="col-12 col-md-6 order-2 order-md-1">
                <x-card.card title="Episode - {{ $video->episode }} {{ $video->name }}">
                    <div class="list-group list-group-flush">
                        @foreach ($videos->filter(fn($data) => !str_contains($data->video_code, 'documents')) as $data)                            
                            <a href="{{ route('series.video', [$series->slug, $data->episode]) }}"
                                class="list-group-item list-group-item-action {{ request()->segment(3) == $data->episode ? 'active' : '' }}"
                                aria-current="true">
                                Eps - {{ $data->episode }} {{ $data->name }}
                                <span class="badge bg-{{ $data->intro == 1 ? 'azure' : 'red' }} ml-1">
                                    {{ $data->intro == 1 ? 'free' : 'pro' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </x-card.card>
            </div>
            <div class="col-md-6 col-12 order-1">
                <div class="card rounded-lg">
                    <div class="card-body">
                        <h3 class="card-title">{{ $series->name }}</h3>
                        <details id="details-c">
                            <summary class="text-primary d-md-none" style="cursor: pointer;">Show Details</summary>
                            @foreach ($series->tags as $tag)
                                <span class="badge bg-{{ $tag->color }}">{{ $tag->name }}</span>
                            @endforeach
                            <p class="text-muted">{{ $series->description }}</p>
                            <p class="text-muted">{{ $series->videos->filter(fn($video) => !str_contains($video->video_code, 'documents'))->count() }} Episode</p>
                        </details>
                    </div>
                </div>
            </div>            
        </div>
    </div>        
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const details = document.getElementById("details-c");
        
            function toggleDetails() {
                if (window.innerWidth >= 768) {
                    details.setAttribute("open", "open");
                } else {
                    details.removeAttribute("open");
                }
            }
        
            toggleDetails(); 
            window.addEventListener("resize", toggleDetails); 
        });
    </script>        
@endsection
