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
       echo json_encode(["error":"Lyrics seems like doesn\'t exist.", "isError":true]);
    }
  } else {
    echo json_encode(["error":"Track id seems like doesn\'t exist.", "isError":true]);
  }
} else {
  $title = urlencode($_GET['t']);
  $artist = urlencode($_GET['a']);
  $duration = $_GET['d'];
  if($duration != null) {
    $lyrics = $musix->getLyricsAlternative(/*title=*/ $title, /*artist name=*/ $artist, /*songs duration=*/ convertDuration($duration));
  } else {
    $lyrics = $musix->getLyricsAlternative(/*title=*/ $title, /*artist name=*/ $artist);
  }
  if($lyrics != null) {
    echo $lyrics;
  } else {
    echo json_encode(["error":"Track id seems like doesn\'t exist.", "isError":true]);
  }
}

function convertDuration($time) {
  list($minutes, $seconds) = explode(":", $time);
  $totalSeconds = ($minutes * 60) + $seconds;
  return $totalSeconds;
}

?>
