@extends ('layouts.app')

@section('title')
    Редактирование альбома
@endsection

@section('content')
    <h1>Редактирование альбома</h1>


    <img src="{{ asset('/storage/' . $data->img) }}" alt="album preview" style="width:120px; height:120px;">
    <form action="{{ route('albumSpecific-update-submit', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="hidden_img" id="hidden_img" value="{{ $data->img }}" hidden>
        <div class="form-group mt-5">
            <label for="img">Выберите изображение для обложки</label>
            <input type="file" name="img" id="img">
        </div>
        <div class="form-group">
            <label for="artist">Введите исполнителя</label>
            <input class="form-control" type="text" name="artist" placeholder="Исполнитель" id="artist"
                   value="{{ old('artist')  ??  $data->artist}}">
        </div>

        <div class="form-group">
            <label for="album">Введите название альбома</label>
            <input class="form-control" type="text" name="album" placeholder="Название альбома" id="album"
                   value="{{ old('album') ?? $data->album }}">
        </div>
        <div class="form-group">
            <label for="info">Введите информацию об альбоме</label>
            <textarea class="form-control" rows="6" name="info" id="info"
                      placeholder="введите информацию">{{ old('info') ?? $data->info }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
@endsection
