# MusixMatch-Lyrics
Easily get music Synced Lyrics by using MusixMatch API written in PHP!

### Examples

#### Using Alternative Method

To retrieve lyrics using the alternative method, use the `/getLyricsMusix.php` endpoint with the following parameters:
- `t`: The title of the song
- `a`: The artist's name
- `d`: The duration of the song (you can specify the duration in either `mm:ss` format or in total seconds)

Example:

```
https://paxsenixofc.my.id/server/getLyricsMusix.php?t=Hope&a=XXXTENTACION&d=1:50&type=alternative
```

#### Using Default Method

To retrieve lyrics using the default method, use the `/getLyricsMusix.php` endpoint with the following parameter:
- `q`: The query string containing the song title and artist name

Example:

```
https://paxsenixofc.my.id/server/getLyricsMusix.php?q=Hope%20XXXTentacion&type=default
```

---

### Response:

```
[00:02.80]Yeah
[00:05.56]♪
[00:11.06]Rest in peace to all the kids that lost their lives in the Parkland shooting
[00:13.63]This song is dedicated to you
```

### How to Use

#### Lyrics Synced Alternative

```php
include_once("./Musixmatch.php");
$musix = new MusixLyricsApi\Musix(); 
echo $musix->getLyricsAlternative("Hope", "XXXTENTACION");
```

#### Lyrics Synced Default

```php
include_once("./Musixmatch.php");
$musix = new MusixLyricsApi\Musix();
$track_id = $musix->searchTrack("Hope XXXTENTACION");      
echo $musix->getLyrics($track_id);
```

### Information

I'm sorry if the code looks weird; I'm working only on a phone (I don't have a PC/Laptop) and I'm still a beginner. :)

### Idea

I started searching for lyrics APIs because of this repository: [Spotify Lyrics API by akashrchandran](https://github.com/akashrchandran/spotify-lyrics-api)

---