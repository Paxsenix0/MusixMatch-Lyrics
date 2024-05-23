# MusixMatch-Lyrics
Easily get music Synced Lyrics by using MusixMatch API written in PHP!

### Examples

__Using alternative method__
Use endpoint `/getLyricsMusix.php`.
and parameter
• `t` => title song
• `a` => artist name
• `d` => duration song, **You can use it as duration format `1:50` or `111`

```
https://paxsenixofc.my.id/server/getLyricsMusix.php?t=Hope&a=XXXTENTACION&d=1:50&type=alternative
```
__Using default method__

```
https://paxsenixofc.my.id/server/getLyricsMusix.php?q=Hope%20XXXTentacion&type=default
```
response:

```
[00:02.80]Yeah
[00:05.56]♪
[00:11.06]Rest in peace to all the kids that lost their lives in the Parkland shooting
[00:13.63]This song is dedicated to you
```

### How to use
__Lyrics Synced Alternative__

```Php

    include_once("./Musixmatch.php");

    $musix = new MusixLyricsApi\Musix(); 
    echo $musix->getLyricsAlternative("Hope", "XXXTENTACION");

```

__Lyrics Synced Default__

```Php
    include_once("./Musixmatch.php");

    $musix = new MusixLyricsApi\Musix();
    $track_id = $musix->searchTrack("Hope XXXTENTACION");      
    echo $musix->getLyrics($track_id);
```


### Information
i'm sorry if the code is too weird, because i'm only using Phone (i don't have PC/Laptop) and i'm still beginner:)

### Idea
i'm doing searching about lyrics API because of this repo :) https://github.com/akashrchandran/spotify-lyrics-api