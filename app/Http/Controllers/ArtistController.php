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

        if (is_string($request->img_api)) {
            $imgSource = $this->imageSave('artists', $request->img_api);
        } else if (file_exists($request->file('img'))) {
            $imgSource = $request->file('img')->store('artists', 'public');
        } else {
            $imgSource = 'stockAlbumImage.jpg';
        }

        Artist::create([
            'user_id' => auth()->user()->id,
            'artist' => $request->input('artist'),
            'img' => $imgSource,
        ]);

        return redirect()->route('artistList')->with('success', "Исполнитель был добавлен");
    }

    public function imageSave($dir, $imgSource)
    {
        $fileContent = file_get_contents($imgSource);
        $path_info = pathinfo(basename($imgSource));
        $ext = $path_info['extension'];
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

    public function edit($id)
    {
        return view('artistUpdate', ['data' => Artist::findOrFail($id)]);
    }

    public function update($id, ArtistRequest $request)
    {
        $previousImg = $request->hidden_img;
        if (file_exists($request->file('img'))) {
            if ($previousImg != 'stockAlbumImage.jpg') {
                Storage::disk('public')->delete($previousImg);
            }
            $imgSource = $request->file('img')->store('artists', 'public');
        } else {
            $imgSource = $previousImg;
        }
        Artist::findOrFail($id)->update([
            'user_id' => auth()->user()->id,
            'artist' => $request->input('artist'),
            'img' => $imgSource,
        ]);

        return redirect()->route('artistList', $id)->with('success', "Исполнитель был обновлен");
    }

    public function delete($id)
    {
        $artistCopy = Artist::findOrFail($id);
        $artistCopy->delete();
        if ($artistCopy->img != 'stockAlbumImage.jpg') {
            Storage::disk('public')->delete($artistCopy->img);
        }
        return redirect()->route('artistList', $id)->with('success', "Исполнитель был Удален");
    }
}
