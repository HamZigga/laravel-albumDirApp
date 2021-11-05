@extends ('layouts.app')

@section('title')
    Описание альбома
@endsection

@section('content')
        <h1>{{ $data->artist }} — {{ $data->album }}</h1>
        <div class="row">
            <img src="{{ $data->img }}" alt="preview" class="col-3 h-100">
            <div class="col-8" >

                <p>{{ $data->info }}</p>
                <p><small>{{ $data->created_at }}</small></p>
                @auth
                    <a href="{{ route('albumSpecific-update', $data->id) }}"><button class="btn btn-primary">Редактировать</button></a>
                    <a href="{{ route('albumSpecific-delete', $data->id) }}"><button class="btn btn-danger">Удалить</button></a>
                @endauth
            </div>
        </div>
@endsection
