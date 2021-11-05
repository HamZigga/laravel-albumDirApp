<?php

namespace App\Http\Controllers;


use App\Models\Album;

use App\Http\Requests\AlbumRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\Utils\Image;


class AlbumController extends Controller
{

    public function store(AlbumRequest $request)
    {
        if (is_string($request->input('img'))) {
            $imgSource = $request->input('img');
            $imgSource = $this->imageSave('albums', $imgSource);
        } else if ($request->file('img') !== null) {
            $imgSource = $request->file('img')->store('albums', 'public');
        } else {
            $imgSource = 'def.png';
        }
        Album::create([
            'user_id' => auth()->user()->id,
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'img' => $imgSource,
            'info' => $request->input('info'),
        ]);

        return redirect()->route('home')->with('success', "Альбом был добавлен");
    }

    public function imageSave($dir, $imgSource)
    {
        $toStorage = file_get_contents($imgSource);
        $basename = basename($imgSource);
        $path_info = pathinfo($basename);
        $ext = $path_info['extension'];
        $name = Str::random(40) . '.' . $ext;
        Storage::disk('public')->put($dir . '/' . $name, $toStorage);
        $imgSource = 'albums/' . $name;
        return $imgSource;
    }

    public function search(Request $request)
    {
        return view('search', ['albums' => Album::where('artist', 'LIKE', "%{$request->input('search')}%")
            ->orderBy('id', 'desc')->get()]);
    }

    public function index()
    {
        return view('home', ['albums' => Album::orderBy('id', 'desc')->paginate(5)]);
    }

    public function edit($id)
    {
        return view('albumUpdate', ['data' => Album::findOrFail($id)]);
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

        return redirect()->route('home', $id)->with('success', "Альбом был обновлен");
    }

    public function delete($id)
    {
        Album::findOrFail($id)->delete();
        return redirect()->route('home', $id)->with('success', "Альбом был Удален");
    }


}


