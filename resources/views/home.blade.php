@extends ('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')
    <p>Поиск по исполнителям</p>
    <form class="form flex col-6 mb-6" action="{{ route('search') }}" method="get">
        @csrf
        <input class="form-control mr-sm-2" type="text" id="search" name="search" placeholder="Найти по исполнителю">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>

    <h2>Список альбомов</h2>

    @foreach($albums as $data)

        @include('inc.itemAlbum')

    @endforeach

    {{ $albums->links() }}



@endsection
