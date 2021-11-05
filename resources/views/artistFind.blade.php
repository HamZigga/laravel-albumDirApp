@extends ('layouts.app')

@section('title')
    Создание альбома
@endsection

@section('content')
    <h1>Поиск исполнителя на стороннем ресурсе</h1>

    <form action="{{ route('artistFind-form') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist" >
        </div>

        <button type="submit" class="btn btn-success">Найти</button>
    </form>
@endsection
