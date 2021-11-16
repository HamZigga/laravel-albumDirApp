<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\ArtistRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class ArtistController extends Controller
{
    public function store(ArtistRequest $request)
    {

        Artist::create([
            'user_id' => auth()->user()->id,
            'artist' => $request->artist,
            'img' => $this->imageSave($request, 'artists'),
        ]);

        return redirect()->route('artistList')->with('success', "Исполнитель был добавлен");
    }

    public function imageSave(ArtistRequest $request, $dir)
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
        return view('artistSearch', ['artists' => Artist::where('artist', 'LIKE', "%{$request->input('search')}%")
            ->orderBy('id', 'desc')->get()]);
    }

    public function index()
    {
        return view('artistList', ['artists' => Artist::orderBy('id', 'desc')->paginate(5)]);
    }

    public function edit($modelId)
    {
        return view('artistUpdate', ['data' => Artist::findOrFail($modelId)]);
    }

    public function update($modelId, ArtistRequest $request)
    {
        Artist::findOrFail($modelId)->update([
            'user_id' => auth()->user()->id,
            'artist' => $request->artist,
            'img' => $this->imageSave($request, 'artists'),
        ]);

        return redirect()->route('artistList', $modelId)->with('success', "Исполнитель был обновлен");
    }

    public function delete($modelId)
    {
        $artistCopy = Artist::findOrFail($modelId);
        $artistCopy->delete();
        if ($artistCopy->img != 'stockAlbumImage.jpg') {
            Storage::disk('public')->delete($artistCopy->img);
        }
        return redirect()->route('artistList', $modelId)->with('success', "Исполнитель был Удален");
    }
}
