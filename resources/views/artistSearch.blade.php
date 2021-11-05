@extends ('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')

    <h2>Список найденных альбомов</h2>
        @foreach($artists as $data)
            @include('inc.itemArtist')
        @endforeach

@endsection
