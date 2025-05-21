@extends('layouts.backend.master')

@section('title', 'Cart')
@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">               
                <x-card.card-action title="Shopping Cart" url="">
                    <x-table.table-responsive>
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Cover</th>
                                <th>Episode</th>
                                <th>Level</th>                                
                                <th>Status</th>
                                <th>Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $data )                            
                            <tr>
                                <td>
                                    <input class="form-check-input border-dark item-checkbox" type="checkbox">              
                                    <input type="hidden" name="series_id[]" value="{{ $data->series->id }}">
                                </td>
                                <td>
                                    <a href="{{ route('series.show', $data->series->slug) }}" class="text-dark">
                                        {{$data->series->name}}  
                                    </a>                                    
                                </td>   
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modal-simple{{ $data->series->id }}"
                                        class="avatar rounded me-2" style="background-image: url({{ $data->series->cover }})">
                                    </a>
                                    <x-modal.modal id="{{ $data->series->id }}" title="Cover : {{ $data->series->name }}">
                                        <img src="{{ $data->series->cover }}" alt="{{ $data->series->name }}"
                                            class="img-fluid" />
                                    </x-modal.modal>
                                </td>
                                <td style="width: max-content;">
                                    {{ $data->series->videos->filter(fn($video) => !str_contains($video->video_code, 'documents'))->count() }} eps
                                </td>                                                          
                                <td>
                                    {{$data->series->level}}                        
                                </td>                            
                                <td>
                                    {{ $data->series->status == '0' ? 'Ongoing' : 'Finished' }}
                                </td>
                                <td class="price">
                                   Rp {{ number_format($data->series->price) }}
                                </td>
                                <td class="text-center">                                  
                                    <form action="{{ route('carts.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>                                    
                                </td>
                            </tr>
                            @endforeach
                            @if ($carts->count() > 0)
                            <tr>
                                <td>
                                    <input class="form-check-input border-dark mr-1" type="checkbox" id="selectAll">All
                                </td>
                                <td class="font-weight-bold text-uppercase text-end">
                                    Grand Total
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="total-price" class="font-weight-bold text-left text-primary">
                                    Rp. 0
                                </td>
                                <td class="text-center">                                   
                                    <form action="{{ route('carts.stores') }}" method="POST" id="series-container">
                                        @csrf
                                        <x-button.button-save icon="shopping-bag" title="Checkout" class="btn btn-warning" />                                    
                                    </form>   
                                </td>
                            </tr>                           
                            @endif
                        </tbody>
                        
                    </x-table.table-responsive>
                </x-card.card-action>               
            </div>
        </div>
    </div>
    <script>
        document.getElementsByClassName("input-icon")[0].classList.add("invisible");       
    </script>
@endsection
