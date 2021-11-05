@extends ('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')


    <h2>Список найденных альбомов</h2>
        @foreach($albums as $data)
            @include('inc.item')
        @endforeach

@endsection
