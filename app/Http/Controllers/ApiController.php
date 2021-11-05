<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use SimpleXMLElement;

class ApiController extends Controller
{

    public function getAlbumApiData(Request $request)
    {
        $patternForDeleteLinks = '/<a([\s\S]+)?>([\s\S]+)?<\/a>/i';

        $albumCopy = new Album();
        $albumCopy->user_id = auth()->user()->id;

        $artist = strtolower(strip_tags($request->input('artist')));
        $album = strtolower(strip_tags($request->input('album')));

        $client = new Client();
        try {
            $client = $client->request('POST', 'https://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=' . env('API_KEY_LASTFM') . '&artist=' . $artist . '&album=' . $album);
        } catch (ClientException  $exception) {
            return redirect()->route('albumFind')->with('errorMessage', "Неверно введен Исполнитель или Альбом");
        }

        $result = new SimpleXMLElement($client->getBody());

        $artist = strval($result->album[0]->artist);
        $album = strval($result->album[0]->name);

        $image = strval($result->album[0]->image[3]);
        if (empty($image)) {
            $image = "https://via.placeholder.com/300.png";
        }

        $info = "";
        if (isset($result->album[0]->wiki[0]->summary)) {
            $info = preg_replace($patternForDeleteLinks, "", $result->album[0]->wiki[0]->summary);
        }

        $albumCopy->artist = $artist;
        $albumCopy->album = $album;
        $albumCopy->img = $image;
        $albumCopy->info = $info;

        return view('albumCreate', ['data' => $albumCopy]);
    }


    // Всегда получает одинаковую картинку из-за изменения правил пользования api last.fm

    public function getArtistApiData(Request $request)
    {
        $ArtistCopy = new Artist();
        $ArtistCopy->user_id = auth()->user()->id;

        $artist = strip_tags($request->input('artist'));

        $client = new Client();
        try {
            $client = $client->request('POST', 'http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=' . $artist . '&api_key=' . env('API_KEY_LASTFM'));
        } catch (ClientException  $exception) {
            return redirect()->route('artistFind')->with('errorMessage', "Исполнитель не найден");
        }

        $result = new SimpleXMLElement($client->getBody());

        $artist = strval($result->artist[0]->name);

        $image = strval($result->artist[0]->image[3]);
        if (empty($image)) {
            $image = "https://via.placeholder.com/300.png";
        }

        $ArtistCopy->artist = $artist;
        $ArtistCopy->img = $image;

        return view('artistCreate', ['data' => $ArtistCopy]);
    }

}

