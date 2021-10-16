@extends ('layouts.app')

@section('title')
    Создание альбома
@endsection

@section('content')
        <h1>{{ $date->artist }} — {{ $date->album }}</h1>
        <div class="row">
            <img src="{{ $date->img }}" alt="preview" class="col-3 h-100">
            <div class="col-8" >   
                
                <p>{{ $date->info }}</p>
                <p><small>{{ $date->created_at }}</small></p>
                @auth
                    <a href="{{ route('specificAlbum-update', $date->id) }}"><button class="btn btn-primary">Редактировать</button></a>
                    <a href="{{ route('specificAlbum-delete', $date->id) }}"><button class="btn btn-danger">Удалить</button></a>
                @endauth
            </div>
        </div>
@endsection