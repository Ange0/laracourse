<?php
namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeService 
{
    private $key = null;

    public function __construct($key)
    {
        $this->key=$key;
    }

    public function videoDuration(string $video_url )
    {
        
  
      
    
        // recuperer l'id a partir de la video_url
        // https://www.youtube.com/embed/hccLteUCwT0
        preg_match('/embed\/(.*)/',$video_url,$matches); //matches==id
        $id =$matches[1];
       // dd($id);


        // appel de l'API youtube
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?key=".$this->key."&id=".$id."&part=contentDetails");
        $decoded = json_decode($response);
        $duration = $decoded->items[0]->contentDetails->duration;


        // convertir la duree iso en HMS
        $interval = new DateInterval($duration); //i=min, s=second, h=heure 
        return $interval->s = $interval->i * 60 + $interval->h * 3600;
   

    }
}
