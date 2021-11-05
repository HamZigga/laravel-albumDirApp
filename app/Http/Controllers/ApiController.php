<?php

namespace App\Http\Controllers;

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
        $apiKey = "488a0683f926f90cdc3a2f16a2355e6a";

        $albumCopy = new Album();
        $albumCopy->user_id = auth()->user()->id;

        $artist = strtolower(strip_tags($request->input('artist')));
        $album = strtolower(strip_tags($request->input('album')));

        $client = new Client();
        try {
            $client = $client->request('POST', 'https://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=' . $apiKey . '&artist=' . $artist . '&album=' . $album);
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

}

