<?php

$type = $_GET['type'];

include_once('./Musixmatch.php');

$musix = new MusixLyricsApi\Musix();
$musix->checkTokenExpire();

if($type === 'default') {
$query = urlencode($_GET['q']);
$track_id = $musix->searchTrack($query);
if($track_id != null) {
$response = $musix -> getLyrics($track_id);
   if(isset($response)) {
      echo $response;
   } else {
      echo '{
            "error":"Lyrics seems like doesn\'t exist.",
            "isError":true
            }';
   }
} else {

echo '{
            "error":"Track id seems like doesn\'t exist.",
            "isError":true
            }';

}
} else {

$title = urlencode($_GET['t']);
$artist = urlencode($_GET['a']);
$duration = $_GET['d'];
if($duration != null) {
$lyrics = $musix->getLyricsAlternative($title, $artist, convertDuration($duration));
} else {
$lyrics = $musix->getLyricsAlternative($title, $artist);
}
if($lyrics != null) {
      echo $lyrics;
} else {

echo '{
            "error":"Track id seems like doesn\'t exist.",
            "isError":true,
            "title":"'.$title.'",
            "artist":"'.$artist.'",
            "duration":"'.convertDuration($duration).'"
            }';

}
}

function convertDuration($time) {
list($minutes, $seconds) = explode(":", $time);
$totalSeconds = ($minutes * 60) + $seconds;

return $totalSeconds;
}

?>