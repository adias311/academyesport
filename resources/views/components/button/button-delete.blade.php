<a href="#" onclick="deleteData({{ $id }})" {{ $attributes->merge(['class' => 'text-danger'])  }}>
    <i class="fas fa-eraser mr-2 text-danger"></i>
    {{ $title }}
</a>
<form id="delete-form-{{ $id }}" action="{{ $url }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="user_id" value="{{$id}}">
</form>
