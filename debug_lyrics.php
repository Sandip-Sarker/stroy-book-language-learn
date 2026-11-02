<?php
use App\Models\Lyrics;
use App\Models\Song;

$id = 1;
$song = Song::find($id);
$lyrics = Lyrics::where('song_id', $id)->get();

echo "Song: " . ($song ? $song->title : 'Not Found') . "\n";
echo "Lyrics Count: " . $lyrics->count() . "\n";
foreach ($lyrics as $lyric) {
    echo " - Lyric ID: {$lyric->id}, Start: {$lyric->start_time}, End: {$lyric->end_time}\n";
}
