@extends('layouts.backend.master')

@section('title', 'List Video')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <x-card.card title="Playlists - {{ $series->name }}">
                    <x-card.card-list>
                        @forelse($videos->reject(fn($video) => str_contains($video->video_code, 'document')) as $i => $video)
                        <x-card.card-list-item title="{{ $video->name }}" eps="{{ $video->episode }}"
                            duration="{{ $video->duration }}" intro="{{ $video->intro }}" uri="{{ route('series.video', [$series->slug, $video->episode]) }}">
                            <x-button.button-link class="dropdown-item" title="Edit"
                                url="{{ route('admin.videos.edit', [$series->slug, $video->video_code]) }}"
                                icon="edit" />
                            <x-button.button-delete id="{{ $video->id }}"
                                url="{{ route('admin.videos.destroy', $video->id) }}" title="Delete"
                                class="dropdown-item" />
                        </x-card.card-list-item>
                    @empty
                        <x-alert.alert-danger title="This Series don't have any video" subTitle="Create new video"
                            url="{{ route('admin.videos.create', $series->slug) }}" icon="play-circle" />
                    @endforelse                    
                    </x-card.card-list>
                </x-card.card>
            </div>
            <div class="col-12">
                <x-card.card title="Documents - {{ $series->name }}">
                    <x-card.card-list>
                        @forelse($videos->filter(fn($video) => str_contains($video->video_code, 'document')) as $i => $video)
                            <x-card.card-list-item title="{{ $video->name }}" eps="{{ $video->episode }}"
                                duration="" intro="{{ $video->intro }}" uri="{{ route('series.document', [$series->slug, $video->episode]) }}">
                                <x-button.button-link class="dropdown-item" title="Edit"
                                    url="{{ route('admin.documents.edit', $video->id) }}"
                                    icon="edit" />
                                <x-button.button-delete id="{{ $video->id }}"
                                    url="{{ route('admin.videos.destroy', $video->id) }}" title="Delete"
                                    class="dropdown-item" />
                            </x-card.card-list-item>
                        @empty
                            <x-alert.alert-danger title="This Series don't have any document" subTitle="Create new document"
                                url="{{ route('admin.documents.create', $series->slug) }}" icon="play-circle" />
                        @endforelse              
                    </x-card.card-list>
                </x-card.card>
            </div>
        </div>
    </div>
@endsection
