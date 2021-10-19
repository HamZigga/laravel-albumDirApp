<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\AlbumLog;
use App\Http\Requests\AlbumRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AlbumController extends Controller{
    
    public function allData() {
        $albumCopy = new Album();
        $albums = DB::table('albums');
        return view('home', [
            'albums' => DB::table('albums')->orderBy('id', 'desc')->paginate(16)
        ]);
    }

    public function updateAlbum($id){
        try {
            $albumCopy = new Album();
            Album::where('id',$id)->firstOrFail();
            return view('albumUpdate', ['date' => $albumCopy->find($id)]);
        }
        catch(Exception $exception){
            return $exception->getMessage();
        }
    }

    public function updateAlbumSubmit($id, AlbumRequest $request) {
        try {
            $albumCopy = new Album();
            $copy = new Album;
            $copy = $albumCopy->find($id);
            Album::where('id',$id)->firstOrFail();

            $albumCopy = $albumCopy->find($id);
            $albumCopy->user_id = Auth::user()->id;
            $albumCopy->artist = $request->input('artist');
            $albumCopy->album = $request->input('album');
            $albumCopy->img = $request->input('img');
            $albumCopy->info = $request->input('info');

            $albumLog = new AlbumLog();
            $albumLog->user_id = Auth::user()->id;
            $albumLog->album_id = $copy->id;
            $albumLog->old_artist = $copy->artist;
            $albumLog->new_artist = $request->input('artist');
            $albumLog->old_album = $copy->album;
            $albumLog->new_album = $request->input('album');
            $albumLog->old_img = $copy->img;
            $albumLog->new_img = $request->input('img');
            $albumLog->old_info = $copy->info;
            $albumLog->new_info = $request->input('info');

            $albumCopy->save();
            $albumLog->save();

            return redirect()->route('specificAlbum', $id)->with('success', "Альбом был обновлен");
        }
        catch(Exception $exception){
            return $exception->getMessage();
        }    
    }


    public function showSpecificAlbum($id) {
        try {
            $albumCopy = new Album();
            Album::where('id',$id)->firstOrFail();
            return view('albumSpecific', ['date' => $albumCopy->find($id)]);
        }
        catch(Exception $exception){
            return $exception->getMessage();
        }
    }

    public function deleteAlbum($id){
        try {
            $albumCopy = new Album();
            Album::where('id',$id)->firstOrFail();
            $albumCopy->find($id)->delete();
            return redirect()->route('home', $id)->with('success', "Альбом был Удален");
        }
        catch(Exception $exception){
            return $exception->getMessage();
        }
    }


}


