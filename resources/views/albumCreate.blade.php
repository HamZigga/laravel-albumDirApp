@extends ('layouts.app')

@section('title')
    Добавление альбома
@endsection

@section('content')
    <h1>Добавление альбома</h1>
    <a class="btn btn-primary" style="margin-bottom: 20px;" href="{{ route('albumFind') }}">Предзаполнение полей</a>
    <img src="{{ $date->img  ?? old('img') ?? "https://via.placeholder.com/300.png" }}" alt="album preview"
         style="width:120px; height:120px;">

    <form action="{{ route('albumCreate-submit') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="img"></label>
            <input class="form-control" type="text" name="img" placeholder="Введите ссылку на картинку" id="img"
                   value="{{ $date->img ?? old('img') ?? 'https://via.placeholder.com/300.png' }}">
        </div>
        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist"
                   value="{{ $date->artist ?? old('artist')  ?? '' }}">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album"
                   value="{{ $date->album ?? old('album')  ?? '' }}">
        </div>
        <div class="form-group">
            <label for="info">Введите информацию об альбоме</label>
            <textarea class="form-control" rows="6" name="info" id="info"
                      placeholder="введите информацию">{{ $date->info ?? old('info')  ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection
