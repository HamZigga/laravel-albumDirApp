@extends ('layouts.app')

@section('title')
    Home page
@endsection

@section('content')
    <h2>Album list</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
    @foreach($albums as $el)
        <div class="col">
            <div class="card shadow-sm" style="margin-bottom:20px">
                <img src="{{ $el->img }}" alt="album preview" class="bd-placeholder-img card-img-top">
                <div class="card-body">
                    <h4 class="card-text">{{ $el->album }}</h4>
                    <p class="card-text">{{ $el->artist }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="{{ route('specificAlbum', $el->id) }}" ><button class="btn btn-sm btn-outline-secondary">Подробнее</button></a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach
    
    </div>
    {{ $albums->links() }}
@endsection
