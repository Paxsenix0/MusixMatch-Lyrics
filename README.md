# MusixMatch-Lyrics
Easily get music Synced Lyrics by using MusixMatch API written in PHP!

## Lyrics Synced Alternative

```Php

    include_once("./Musixmatch.php");

    $musix = new MusixLyricsApi\Musix(); 
    echo $musix->getLyricsAlternative("Hope", "XXXTENTACION");

```

## Lyrics Synced Default 

```Php
    include_once("./Musixmatch.php");

    $musix = new MusixLyricsApi\Musix();
    $track_id = $musix->searchTrack("Hope XXXTENTACION");      
    echo $musix->getLyrics($track_id);
```


## Information
i'm sorry if the code is too weird, because i'm only using Phone (i don't have PC/Laptop) and i'm still beginner:)
