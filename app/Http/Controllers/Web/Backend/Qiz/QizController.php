<?php

namespace App\Http\Controllers\Web\Backend\Qiz;

use App\Http\Controllers\Controller;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\Song;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Crypt\EC\Formats\Keys\Common;
use Yajra\DataTables\DataTables;

class QizController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Song::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $defaultImage = asset($data->image);
                    $url = $data->image ? url(Storage::url($data->image)) : $defaultImage;
                    // $url = $data->thumbnail ? asset('storage/' . $data->thumbnail) : $defaultImage;

                    return '<img src="' . $url . '" alt="Avatar" width="50" height="50" style="object-fit:cover; border-radius:50%;">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('qiz.show', ['id' => $data->id]) . '" type="button" class="btn btn-info-gradient fs-14 text-white edit-icn" title="Edit">
                                    Details
                                </a>
                                 <a href="' . route('qiz.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary-gradient fs-14 text-white edit-icn" title="Edit">
                                   QIZ Create
                                </a>
                            </div>';
                })
                ->rawColumns(['action', 'image'])
                ->make();
        }
        return view('backend.layouts.qiz.index');
    }

//    public function create()
//    {
//        $songs = Song::all();
//        return view('backend.layouts.qiz.create', compact('songs'));
//    }
//
//    public function store(Request $request)
//    {
//        // Optional validation
//        $request->validate([
//            'song_id' => 'required|integer',
//            'questions' => 'required|array|min:1',
//        ]);
//
//        foreach ($request->questions as $questionData) {
//
//            // 1️⃣ Insert Question
//            $quizQuestion = QuizQuestion::create([
//                'song_id'  => $request->song_id,
//                'question' => $questionData['question'],
//            ]);
//
//            // 2️⃣ Insert Options
//            foreach ($questionData['options'] as $label => $optionText) {
//
//                QuizOption::create([
//                    'quiz_question_id' => $quizQuestion->id,
//                    'option_label'     => $label,
//                    'option_text'      => $optionText,
//                    'is_correct'       => ($label === $questionData['correct']), // ✅ true / false
//                ]);
//            }
//        }
//
//        return redirect()->back()->with('t-success', 'Quiz created successfully!');
//    }

    public function show($id)
    {
        $data = QuizQuestion::with('quizOptions')->where('song_id', $id)->get();
        return view('backend.layouts.qiz.show', compact('data'));
    }

    public function edit($id)
    {
        $songs = Song::all();
        $data = QuizQuestion::with('quizOptions')->where('song_id', $id)->get();
        return view('backend.layouts.qiz.edit', Compact('songs', 'data', 'id'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validation
        $request->validate([
            'questions' => 'required|array|min:1',
        ]);

        // 2. Identify keys to keep
        // Collect all IDs from the submitted data that are not null
        $submittedIds = collect($request->questions)->pluck('id')->filter()->toArray();

        // 3. Delete missing questions
        // Find questions belonging to this song that are NOT in the submitted list
        QuizQuestion::where('song_id', $id)
            ->whereNotIn('id', $submittedIds)
            ->delete();

        // 4. Loop through submitted questions
        foreach ($request->questions as $qData) {

            // Check if it's an existing question (has ID) or new
            if (isset($qData['id']) && $qData['id']) {
                $question = QuizQuestion::find($qData['id']);
                if ($question) {
                    $question->update([
                        'song_id'  => $id,
                        'question' => $qData['question'],
                    ]);
                }
            } else {
                // Create new Question
                $question = QuizQuestion::create([
                    'song_id'  => $id,
                    'question' => $qData['question'],
                ]);
            }

            if (isset($question)) {
                // 5. Update Options (Delete old, Insert new)
                $question->quizOptions()->delete();

                if (isset($qData['options'])) {
                    foreach ($qData['options'] as $label => $optionText) {
                        QuizOption::create([
                            'quiz_question_id' => $question->id,
                            'option_label'     => $label,
                            'option_text'      => $optionText,
                            'is_correct'       => ($label === ($qData['correct'] ?? null)),
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('t-success', 'Quiz updated successfully!');
    }
}
