<?php

namespace App\Http\Controllers;


use App\Models\Album;

use App\Http\Requests\AlbumRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;


class AlbumController extends Controller
{

    public function store(AlbumRequest $request)
    {

        Album::create([
            'user_id' => auth()->user()->id,
            'artist' => $request->artist,
            'album' => $request->album,
            'img' => $this->imageSave($request, 'albums'),
            'info' => $request->info,
        ]);

        return redirect()->route('home')->with('success', "Альбом был добавлен");
    }

    public function imageSave(AlbumRequest $request, $dir)
    {
        if (is_string($request->img_api)) {
            $fileContent = file_get_contents($request->img_api);
            $path_info = pathinfo(basename($request->img_api));
            $ext = $path_info['extension'];
        } else if (file_exists($request->file('img'))) {

            if ($request->hidden_img != 'stockAlbumImage.jpg') {
                Storage::disk('public')->delete($request->hidden_img);
            }

            $fileContent = $request->file('img');
            $ext = $fileContent->extension();
        } else {
            if (isset($request->hidden_img)) {
                return $request->hidden_img;
            }

            return 'stockAlbumImage.jpg';
        }

        $filename = $dir . '/' . Str::random(40) . '.' . $ext;
        $img = Image::make($fileContent)->encode($ext)->resize(300, 300);
        Storage::disk('public')->put($filename, $img);
        return $filename;

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

    public function edit($modelId)
    {
        return view('albumUpdate', ['data' => Album::findOrFail($modelId)]);
    }

    public function update($modelId, AlbumRequest $request)
    {
        Album::findOrFail($modelId)->update([
            'user_id' => auth()->user()->id,
            'artist' => $request->artist,
            'album' => $request->album,
            'img' => $this->imageSave($request, 'albums'),
            'info' => $request->info,
        ]);

        return redirect()->route('home', $modelId)->with('success', "Альбом был обновлен");
    }

    public function delete($modelId)
    {
        $albumCopy = Album::findOrFail($modelId);
        $albumCopy->delete();
        if ($albumCopy->img != 'stockAlbumImage.jpg') {
            Storage::disk('public')->delete($albumCopy->img);
        }
        return redirect()->route('home', $modelId)->with('success', "Альбом был Удален");
    }


}


