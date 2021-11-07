@extends ('layouts.app')

@section('title')
    Добавление альбома
@endsection

@section('content')

    <h1>Добавление альбома</h1>
    <a class="btn btn-primary" style="margin-bottom: 20px;" href="{{ route('albumFind') }}">Предзаполнение полей</a>
    <img src="{{ $data->img  ?? old('img_api') ??  asset('/storage/stockAlbumImage.jpg' )  }}" alt="album preview"
         style="width:120px; height:120px;">

    <form action="{{ route('albumCreate-submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if(isset($data->img) || old('img_api') != null)
            <div class="form-group">
                <label for="img_api">Ссылка на изображение</label>
                <input class="form-control" type="text" name="img_api" placeholder="Ссылка на изображение" id="img_api"
                       value="{{ old('img_api')  ?? $data->img}}" readonly>
            </div>
        @else
            <div class="form-group mt-5">
                <label for="artist">Выберите изображение для обложки</label>
                <input class="" type="file" name="img" id="img">
            </div>
        @endif


        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist"
                   value="{{ $data->artist ?? old('artist')  ?? '' }}">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album"
                   value="{{ $data->album ?? old('album')  ?? '' }}">
        </div>
        <div class="form-group">
            <label for="info">Введите информацию об альбоме</label>
            <textarea class="form-control" rows="6" name="info" id="info"
                      placeholder="введите информацию">{{ $data->info ?? old('info')  ?? '' }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection
