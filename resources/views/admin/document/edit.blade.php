@extends('layouts.backend.master')

@section('title', 'Create Document')
{{-- @php
    dd($series);
@endphp --}}
@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <x-card.card title="{{ $series->series->name }}">
                    <form action="{{ route('admin.documents.update', $series->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <x-form.input type="text" title="Document Name" name="name" value="{{$series->name}}"
                            placeholder="Input document name" />                        
                        <x-form.input type="file" title="Upload Document" name="document" value=""
                            placeholder="" />                      
                        <div class="row">
                            <div class="col-6">
                                <x-form.input type="number" title="Document Number" name="number" value="{{$series->episode}}"
                                    placeholder="input document number" />
                            </div>
                        </div>
                        <x-form.checkbox title="Intro">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input @error('intro') is-invalid @enderror" type="checkbox"
                                    name="intro" value="1" {{ $series->intro ? 'checked' : '' }}>
                                <span class="form-check-label">Make this an introductory document</span>
                            </label>
                        </x-form.checkbox>
                        <x-button.button-save title="Save" icon="save" class="btn-primary" />
                        <x-button.button-link class="btn btn-dark text-white" title="Go Back" icon="arrow-left"
                            url="{{ route('admin.series.index') }}">
                        </x-button.button-link>
                    </form>
                </x-card.card>
            </div>
        </div>
    </div>
@endsection
