<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Lyrics;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class LyricsController extends Controller
{

    public function createUpdate($id)
    {
        $song = Song::find($id);
        $lyrics = Lyrics::where('song_id', $id)->orderBy('id', 'asc')->get()->map(function ($lyric) {
            return [
                'id'         => $lyric->id,
                'eng_lang'   => $lyric->eng_lang,
                'other_lang' => $lyric->other_lang,
                'start_time' => $lyric->start_time,
                'end_time'   => $lyric->end_time,
            ];
        });
        return view('backend.layouts.lyrics.create', compact('song','lyrics'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lyrics'                => 'required|array|min:1',
            'lyrics.*.start_time'   => 'required|numeric|min:0',
            'lyrics.*.end_time'     => 'required|numeric|gt:lyrics.*.start_time',
        ]);

        $customLyrics = collect($request->lyrics)->sortBy('start_time');
        $previousEndTime = null;

        $submittedIds = [];
        foreach ($customLyrics as $lyric) {
            // Server side overlap validation
            if ($previousEndTime !== null && $lyric['start_time'] < $previousEndTime) {
                return back()->with('t-error', 'Lyrics time overlap detected.');
            }
            $previousEndTime = $lyric['end_time'];

            if (!empty($lyric['id'])) {
                $submittedIds[] = $lyric['id'];
                // Update existing lyrics
                Lyrics::where('id', $lyric['id'])->update([
                    'eng_lang'      => $lyric['eng_lang'],
                    'other_lang'    => $lyric['other_lang'],
                    'start_time'    => $lyric['start_time'],
                    'end_time'      => $lyric['end_time'],
                ]);
            } else {
                // Create new lyrics
                $newLyric = Lyrics::create([
                    'song_id'       => $id,
                    'eng_lang'      => $lyric['eng_lang'],
                    'other_lang'    => $lyric['other_lang'],
                    'start_time'    => $lyric['start_time'],
                    'end_time'      => $lyric['end_time'],
                ]);
                $submittedIds[] = $newLyric->id;
            }
        }

        // Delete missing lyrics
        Lyrics::where('song_id', $id)
              ->whereNotIn('id', $submittedIds)
              ->delete();

        return back()->with('t-success', 'Lyrics saved successfully.');
    }


}
