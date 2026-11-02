<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Http\Controllers\Controller;
use App\Models\Lyrics;
use App\Models\Song;
use App\Models\Vocabulary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VocabularyController extends Controller
{

    public function create($id)
    {
        $song = Song::find($id);
        $vocabularies = Vocabulary::where('song_id', $id)->get();
        return view('backend.layouts.vocabulary.create', compact('song', 'vocabularies'));
    }

    public function createUpdate(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        if ($request->isMethod('post')) {

            $request->validate([
                'vocabularies'              => 'required|array|min:1',
                'vocabularies.*.word'       => 'required|string',
                'vocabularies.*.meaning'    => 'required|string',
                'vocabularies.*.example'    => 'required|string',
            ]);

            $submittedIds = [];

            foreach ($request->vocabularies as $vocab) {

                if (!empty($vocab['id'])) {

                    // UPDATE
                    Vocabulary::where('id', $vocab['id'])->update([
                        'word'    => $vocab['word'],
                        'meaning'=> $vocab['meaning'],
                        'example'=> $vocab['example'],
                    ]);

                    $submittedIds[] = $vocab['id'];

                } else {

                    // CREATE
                    $new = Vocabulary::create([
                        'song_id' => $id,
                        'word'    => $vocab['word'],
                        'meaning'=> $vocab['meaning'],
                        'example'=> $vocab['example'],
                    ]);

                    // IMPORTANT: store new ID
                    $submittedIds[] = $new->id;
                }
            }

            // DELETE removed vocabularies
            Vocabulary::where('song_id', $id)
                ->whereNotIn('id', $submittedIds)
                ->delete();

            return back()->with('t-success', 'Vocabulary saved successfully.');
        }

        $vocabularies = Vocabulary::where('song_id', $id)->get();

        return view('backend.layouts.vocabulary.create', compact('song', 'vocabularies'));
    }
}
