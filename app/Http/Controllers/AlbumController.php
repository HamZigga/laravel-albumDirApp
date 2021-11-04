<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\AlbumLog;
use App\Http\Requests\AlbumRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Exception;

class AlbumController extends Controller
{

    public function store(AlbumRequest $request)
    {
        Album::create([
            'user_id' => auth()->user()->id,
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'img' => $request->input('img'),
            'info' => $request->input('info'),
        ]);

        return redirect()->route('home')->with('success', "Альбом был добавлен");
    }

    public function index()
    {
        return view('home', ['albums' => Album::orderBy('id', 'desc')->paginate(4)]);
    }

    public function edit($id)
    {
        return view('albumUpdate', ['date' => Album::find($id)]);
    }

    public function update($id, AlbumRequest $request)
    {

        Album::find($id)->update([
            'user_id' => auth()->user()->id,
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'img' => $request->input('img'),
            'info' => $request->input('info'),
        ]);

        return redirect()->route('albumSpecific', $id)->with('success', "Альбом был обновлен");
    }

    public function show($id)
    {
        return view('albumSpecific', ['date' => Album::find($id)]);
    }

    public function delete($id)
    {
        Album::find($id)->delete();
        return redirect()->route('home', $id)->with('success', "Альбом был Удален");
    }


}


