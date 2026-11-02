<?php

namespace App\Http\Controllers\API\Song;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Song;
use App\Models\SongCategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SongController extends Controller
{
    use ApiResponse;

    public function songCategory()
    {
        $data = SongCategory::latest()->get();

        return $this->success('Data get successfully', $data, 200);
    }

    public function artist()
    {
        $data = Artist::latest()->get();

        return $this->success('Data get successfully', $data, 200);
    }

    public function song(Request $request)
    {
        $query = Song::query();

        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->difficult) {
            $query->where('difficult', $request->difficult);
        }

        if ($request->category) {
            $query->where('song_category_id', $request->category);
        }

        $data = $query->with('language', 'category', 'artist')
            ->where('status', 'Active')
            ->orderByRaw("FIELD(difficult, 'Beginner', 'Intermediate', 'Advanced') ASC")
            ->latest()
            ->get();

        return $this->success('Data get successfully', $data, 200);
    }

    // details of song with lyrics, vocabularies and quiz questions
    public function songDetails($id)
    {
        $data = Song::with([
            'language',
            'category',
            'artist',
            'lyrics' => function ($query) {
                $query->orderBy('id', 'asc'); // sort lyrics by start_time
            },
            'vocabularies',
            'quizQuestions' => function ($query) {
                $query->inRandomOrder()->limit(5); // Randomize and limit to 5 quiz questions on each refresh
            },
            'quizQuestions.quizOptions' => function ($query) {
                $query->inRandomOrder(); // Randomize quiz options order on each refresh
            },
        ])->find($id);

        return $this->success('Data get successfully', $data, 200);
    }
}
