@extends ('layouts.app')

@section('title')
    Добавление альбома
@endsection

@section('content')
    <h1>Добавление альбома</h1>

    

    <form action="{{ route('albumCreate-form') }}" method="POST">
        @csrf 
        <img src="{{ $image }}" alt="album preview" style="width:120px; height:120px;">
        <div class="hidden">
            <label for="img"></label>
            <input class="form-control" type="text" name="img" placeholder="" id="img" value="{{ $image }}">
        </div>
        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist" value="{{ $artist }}">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album" value="{{ $album }}">
        </div>
        <div class="form-group">
            <label for="info">Введите информацию об альбоме</label>
            <textarea class="form-control" rows="6" name="info" id="info" placeholder="введите информацию">{{ $wiki }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection