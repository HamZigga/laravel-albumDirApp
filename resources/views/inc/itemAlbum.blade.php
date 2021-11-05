<div class="jumbotron" style="padding: 30px">
    <h1>{{ $data->artist }} — {{ $data->album }}</h1>
    <div class="row">
        @if(isset($data->img))
            <img src="{{ asset('/storage/' . $data->img) }}" alt="preview" class="col-3 h-100" style="width: 300px; height: 300px; object-fit: cover;">
        @else
            <img src="{{ asset('/storage/def.png') }}" alt="preview" class="col-3 h-100">
        @endif
        <div class="col-8" >

            <p>{{ $data->info }}</p>
            <p><small>{{ $data->created_at }}</small></p>
            @auth
                <a href="{{ route('albumSpecific-update', $data->id) }}"><button class="btn btn-primary">Редактировать</button></a>
                <a href="{{ route('albumSpecific-delete', $data->id) }}"><button class="btn btn-danger">Удалить</button></a>
            @endauth
        </div>
    </div>
</div>
