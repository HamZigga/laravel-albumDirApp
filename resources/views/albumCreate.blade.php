@extends ('layouts.app')

@section('title')
    Добавление альбома
@endsection

@section('content')
    <h1>Добавление альбома</h1>

    <img src="{{ $date->img }}" alt="album preview" style="width:120px; height:120px;">

    <form action="{{ route('albumCreate-submit') }}" method="POST">
        @csrf 
        
        <div class="hidden">
            <label for="img"></label>
            <input class="form-control" type="text" name="img" placeholder="" id="img" value="{{ $date->img }}">
        </div>
        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist" value="{{ $date->artist }}">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album" value="{{ $date->album }}">
        </div>
        <div class="form-group">
            <label for="info">Введите информацию об альбоме</label>
            <textarea class="form-control" rows="6" name="info" id="info" placeholder="введите информацию">{{ $date->info }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection