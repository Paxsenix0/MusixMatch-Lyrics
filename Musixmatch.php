<?php

namespace MusixLyricsApi;

class Musix
{
    private $token_url = 'https://apic-desktop.musixmatch.com/ws/1.1/token.get?app_id=web-desktop-app-v1.0';
    private $search_term_url = 'https://apic-desktop.musixmatch.com/ws/1.1/track.search?app_id=web-desktop-app-v1.0&page_size=5&page=1&s_track_rating=desc&quorum_factor=1.0';
    private $lyrics_url = 'https://apic-desktop.musixmatch.com/ws/1.1/track.subtitle.get?app_id=web-desktop-app-v1.0&subtitle_format=lrc';
    private $lyrics_alternative = 'https://apic-desktop.musixmatch.com/ws/1.1/macro.subtitles.get?format=json&namespace=lyrics_richsynched&subtitle_format=mxm&app_id=web-desktop-app-v1.0';

    function __construct()
    {
    }
    
    function get($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authority: apic-desktop.musixmatch.com',
            'cookie: AWSELBCORS=0; AWSELB=0;'
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        
        return $result;
    }

    function getToken(): void
    {
        
        $result = $this->get($this->token_url);
        
        // You can choose to store the result in a variable or use it directly.
        
        if (!$result) {
        throw new \Exception('Failed to retrieve the access token.');
        }

        $token_json = json_decode($result, true);
        if (!$token_json['message']['header']['status_code'] == 200) {
            throw new \Exception($result);
         }

        // Save the token to a cache file
        $current_time = time();
        
        $new_token = $token_json["message"]["body"]["user_token"];
        $expiration_time = $current_time + 600;
        $token_data = ["user_token" => $new_token, "expiration_time" => $expiration_time];
        
        $tokenFile = 'musix.txt';
        file_put_contents($tokenFile, json_encode($token_data));
     }

    function checkTokenExpire(): void
    {
      $check = file_exists('musix.txt');
      $timeNow = time();
    if ($check) {
        $json = file_get_contents('musix.txt');
        $timeLeft = json_decode($json, true)['expiration_time'];
    }

    if (!$check || $timeLeft < $timeNow) {
        $this->getToken();
    }
    }

    function getLyrics($track_id): string
    {
        // Implement lyrics retrieval logic here and return the JSON result.
        $json = file_get_contents('musix.txt');
        $token = json_decode($json, true)['user_token'];
        $formatted_url = $this->lyrics_url . '&track_id=' . $track_id . '&usertoken=' . $token;
        
        $result = $this->get($formatted_url);
        
        $lyrics = json_decode($result, true)['message']['body']['subtitle']['subtitle_body'];
        
        return $lyrics;
    }
    
    function getLyricsAlternative($title, $artist, $duration = null): string
    {
        // Implement lyrics retrieval logic here and return the JSON result.
        $json = file_get_contents('musix.txt');
        $token = json_decode($json, true)['user_token'];
        if($duration != null) {
        $formatted_url = $this->lyrics_alternative . '&usertoken=' . $token . '&q_album=&q_artist=' . $artist . '&q_artists=&track_spotify_id=&q_track=' . $title . '&q_duration=' . $duration . '&f_subtitle_length=';
        } else {
        $formatted_url = $this->lyrics_alternative . '&usertoken=' . $token . '&q_album=&q_artist=' . $artist . '&q_artists=&track_spotify_id=&q_track=' . $title . '&q_duration=&f_subtitle_length=';
        }
        
        $result = $this->get($formatted_url);
        
        file_put_contents('music.json', $result);
        
        $lyrics = json_decode($result, true);
        
        $yeee = $lyrics['message']['body']['macro_calls']['track.subtitles.get'];
        
        $track2 = $yeee['message']['body']['subtitle_list'][0]['subtitle']['subtitle_body'];
        
        $lyricsText = $this->getLrcLyrics($track2);
        
        return $lyricsText;
    }
    
    function searchTrack($query): string
{
    // Implement lyrics retrieval logic here and return the JSON result.
    $json = file_get_contents('musix.txt');
    $token = json_decode($json, true)['user_token'];
    $formatted_url = $this->search_term_url . '&q=' . $query . '&usertoken=' . $token;

    $result = $this->get($formatted_url);

    $listResult = json_decode($result, true);

    if (!isset($listResult['message']['body']['track_list'])) {
        throw new \Exception($result);
    }

    foreach ($listResult['message']['body']['track_list'] as $track) {
        $trackObj = $track['track'];

        $trackName = $trackObj['track_name'] . ' ' . $trackObj['artist_name'];

        if (strstr($query, $trackName)) {
            $answer = $trackObj['track_id'];
            return $answer; // Return the result when found
        }
    }

    return $listResult['message']['body']['track_list'][0]['track']['track_id'];
}

    function getLrcLyrics($lyrics): string
    {
        $data = json_decode($lyrics, true);

        $lrc = '';
        
        if(isset($data)) {
        foreach ($data as $item) {
         $minutes = $item['time']['minutes'];
         $seconds = $item['time']['seconds'];
         $hundredths = $item['time']['hundredths'];
         $text = empty($item['text']) ? '♪' : $item['text'];

         $lrc .= sprintf("[%02d:%02d.%02d]%s\n", $minutes, $seconds, $hundredths, $text);
         }
         }

    return $lrc;
    }

}
?>