<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\Album;
use Illuminate\Http\Request;

use SimpleXMLElement;

class ApiController extends Controller
{

    public function getAlbumApiData(Request $request)
    {
        $route = 'albumFind';
        $message = 'Неверно введен Исполнитель или Альбом';
        $patternForDeleteLinks = '/<a([\s\S]+)?>([\s\S]+)?<\/a>/i';

        $albumCopy = new Album();
        $albumCopy->user_id = auth()->user()->id;

        $artist = strtolower(strip_tags($request->artist));
        $album = strtolower(strip_tags($request->album));

        $url = 'https://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=' . env('API_KEY_LASTFM') . '&artist=' . $artist . '&album=' . $album;

        $result = $this->getApiData($url);
        if (!$result){
            return redirect()->route($route)->with('errorMessage', $message);
        }

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
        $route = 'artistFind';
        $message = 'Исполнитель не найден';
        $ArtistCopy = new Artist();
        $ArtistCopy->user_id = auth()->user()->id;

        $artist = strip_tags($request->input('artist'));

        $url = 'http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=' . $artist . '&api_key=' . env('API_KEY_LASTFM');

        $result = $this->getApiData($url);
        if (!$result){
            return redirect()->route($route)->with('errorMessage', $message);
        }

        $artist = strval($result->artist[0]->name);

        $image = strval($result->artist[0]->image[3]);
        if (empty($image)) {
            $image = "https://via.placeholder.com/300.png";
        }

        $ArtistCopy->artist = $artist;
        $ArtistCopy->img = $image;

        return view('artistCreate', ['data' => $ArtistCopy]);
    }

    public function getApiData(string $url)
    {
        $client = new Client();
        try {
            $client = $client->request('POST', $url);
        } catch (ClientException  $exception) {
            return false;
        }

        $result = new SimpleXMLElement($client->getBody());

        if ($result['status'] == 'failed'){
            return false;
        }
        return $result;
    }

}

