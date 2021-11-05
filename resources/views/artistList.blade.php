@extends ('layouts.app')

@section('title')
    Главная страница
@endsection

@section('content')
    <p>Поиск по исполнителям</p>
    <form class="form flex col-6 mb-6" action="{{ route('artistsearch') }}" method="get">
        @csrf
        <input class="form-control mr-sm-2" type="text" id="search" name="search" placeholder="Найти по исполнителю">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>

    <h2>Список Исполнителей</h2>

    @foreach($artists as $data)

        @include('inc.itemArtist')

    @endforeach

    {{ $artists->links() }}



@endsection
