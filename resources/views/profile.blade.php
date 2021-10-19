@extends ('layouts.app')

@section('title')
    Профиль
@endsection

@section('content')
    <h1>Профиль</h1>
    <p>{{ Auth::user()->name }}</p>
    <p>{{ Auth::user()->email }}</p>
@endsection