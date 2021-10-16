<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use SimpleXMLElement;

class ApiController extends Controller
{      
        public function submit(Request $request) {

            $albumCopy = new Album();
            $albumCopy->user_id = Auth::user()->id;
            $albumCopy->artist = $request->input('artist');
            $albumCopy->album = $request->input('album');
            $albumCopy->img = $request->input('img');
            $albumCopy->info = $request->input('info');
            $albumCopy->save();

            return redirect()->route('home')->with('success', "Албом был добавлен");
        }
        
    public function getApiData(Request $request) {
        $albumCopy = new Album();
        $albumCopy->user_id = Auth::user()->id;
        $artist = strtolower($request->input('artist'));
        $album = strtolower($request->input('album'));
        $client = new Client();
        $res = $client->request('POST', 'https://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=488a0683f926f90cdc3a2f16a2355e6a&artist='.$artist.'&album='.$album, [
            'form_params' => [
                'client_id' => 'test_id',
                'secret' => 'test_secret',
            ]
        ]);
        $result= $res->getBody();
        $result = new SimpleXMLElement($result);
        if (isset($result->album[0]->artist)){
            $artist = strval($result->album[0]->artist);
        }
        if (isset($result->album[0]->name)){
            $album = strval($result->album[0]->name);
        }
        $image = "";
        $image = strval($result->album[0]->image[3]);
        $wiki = '';
        $pattern = '/<a([\s\S]+)?>([\s\S]+)?<\/a>/i';
    
        if (isset($result->album[0]->wiki[0]->summary)){
            $wiki = preg_replace($pattern, "", $result->album[0]->wiki[0]->summary);
        }
        $albumCopy->artist = $artist;
        $albumCopy->album = $album;
        $albumCopy->image = $image;
        $albumCopy->wiki = $wiki;
        return view('albumCreate',$albumCopy);
        
    }

    public function allData() {
        $albumCopy = new Album();
        return view('home', ['date' => $albumCopy->orderBy('id', 'desc')->get()]);
    }  

    public function showSpecificAlbum($id) {
        $albumCopy = new Album();
        return view('albumSpecific', ['date' => $albumCopy->find($id)]);
    }
    
    public function updateAlbum($id){
        $albumCopy = new Album();
        return view('albumUpdate', ['date' => $albumCopy->find($id)]);
    }

    public function deleteAlbum($id){
        $albumCopy = new Album();
        $albumCopy->find($id)->delete();
        return redirect()->route('home', $id)->with('success', "Альбом был Удален");
    }

    public function updateAlbumSubmit($id, Request $request) {
       
        $albumCopy = new Album();
        $albumCopy = $albumCopy->find($id);
        $albumCopy->user_id = Auth::user()->id;
        $albumCopy->artist = $request->input('artist');
        $albumCopy->album = $request->input('album');
        $albumCopy->img = $request->input('img');
        $albumCopy->info = $request->input('info');

        $albumCopy->save();

        return redirect()->route('specificAlbum', $id)->with('success', "Альбом был обновлен");
    }
}

