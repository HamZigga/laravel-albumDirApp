@extends ('layouts.app')

@section('title')
    Создание альбома
@endsection

@section('content')
    <h1>Поиск доп инф</h1>
    
    <form action="{{ route('albumFind-form') }}" method="POST">
        @csrf 

        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album">
        </div>
        <button type="submit" class="btn btn-success">Найти</button>
    </form>
@endsection