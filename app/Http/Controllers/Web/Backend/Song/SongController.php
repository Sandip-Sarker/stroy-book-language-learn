<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Language;
use App\Models\Song;
use App\Models\SongCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Exceptions\Exception;
use Yajra\DataTables\DataTables;

class SongController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Song::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("language", function ($data) {
                    return $data->language ? $data->language->name : 'N/A';
                })->addColumn("artist", function ($data) {
                    return $data->artist ? $data->artist->name : 'N/A';
                })
                ->addColumn("category", function ($data) {
                    return $data->category ? $data->category->name : 'N/A';
                })
                ->addColumn('image', function ($data) {
                    $defaultImage = asset($data->image);
                    $url = $data->image ? url(Storage::url($data->image)) : $defaultImage;
                    return '<img src="' . $url . '" alt="Avatar" width="50" height="50" style="object-fit:cover; border-radius:50%;">';
                })
                ->addColumn('audio', function ($data) {
                    if ($data->audio) {
                        // $audioUrl = asset('storage/' . $data->audio_file);
                        $audioUrl = url(Storage::url($data->audio));
                        return '<audio controls style="width:300PX;"><source src="' . $audioUrl . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
                    }
                    return 'N/A';
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor = $data->status == "Active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "Active" ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                 ->addColumn('is_exclusive', function ($data) {
                    $backgroundColor = $data->is_exclusive == 1 ? '#f18b37ff' : '#ccc';
                    $sliderTranslateX = $data->is_exclusive == 1 ? '26px' : '2px';
                    $sliderStyles = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $exclusive = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $exclusive .= '<input onclick="showExclusiveAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="exclusiveSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="is_exclusive" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $exclusive .= '<span style="' . $sliderStyles . '"></span>';
                    $exclusive .= '<label for="exclusiveSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $exclusive .= '</div>';

                    return $exclusive;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('song.show', ['id' => $data->id]) . '" type="button" class="btn btn-info-gradient fs-14 text-white edit-icn" title="Details">
                                    <i class="fe fe-eye"></i>
                                </a>
                                <a href="' . route('song.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary-gradient fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                <a href="' . route('lyrics.create.update', ['id' => $data->id]) . '" type="button" class="btn btn-secondary-gradient fs-14 text-white edit-icn" title="Lyrics">
                                    <i class="fe fe-music"></i>
                                </a>
                                 <a href="' . route('vocabulary.create', ['id' => $data->id]) . '" type="button" class="btn btn-warning-gradient fs-14 text-white edit-icn" title="Vocabulary">
                                    <i class="fa fa-book" style="margin-top: 3px;"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $row->id . '">';
                })
                ->rawColumns(['action', 'checkbox', 'language', 'artist', 'category', 'image', 'audio', 'status', 'is_exclusive'])
                ->make();
        }
        return view('backend.layouts.song.index');
    }

    public function create()
    {
        $data['categories'] = SongCategory::all();
        $data['artists'] = Artist::all();
        $data['languages'] = Language::all();
        return view('backend.layouts.song.create')->with($data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'artist_id' => 'required',
            'song_category_id' => 'required',
            'language_id' => 'required',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'audio' => 'required|file|mimetypes:audio/mp3,audio/mpeg,audio/wav,audio/ogg',

        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = Helper::fileUploadStorage($image, 'song/image', $image->getClientOriginalName());
            }

            if ($request->hasFile('audio')) {
                $audio = $request->file('audio');
                $audioPath = Helper::fileUploadStorage($audio, 'song/audio', $audio->getClientOriginalName());
            }

            $data = new Song();
            $data->artist_id = $request->artist_id;
            $data->language_id = $request->language_id;
            $data->song_category_id = $request->song_category_id;
            $data->title = $request->title;
            $data->short_description = $request->short_description;
            $data->difficult = $request->difficult;
            $data->image = $imagePath ?? null;
            $data->audio = $audioPath ?? null;
            $data->save();

            return redirect()->route('song.index')->with('success', 'Song added successfully.');
        } catch (Exception $e) {
            return back()->with('t-success', 'Some thing went wrong while uploading your file.');
        }
    }

    public function status($id)
    {
        $data = Song::findOrFail($id);

        if ($data->status == 'Active') {
            $data->status = 'Inactive';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            $data->status = 'Active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
    }

    public function exclusive($id)
    {
        $data = Song::findOrFail($id);

        if ($data->is_exclusive == 1) {
            $data->is_exclusive = 0;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Un-exclusive Changed Successfully.',
                'data' => $data,
            ]);
        } else {
            $data->is_exclusive = 1;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Exclusive Changed Successfully.',
                'data' => $data,
            ]);
        }
    }


    public function show($id)
    {
        $data['song'] = Song::with('artist', 'category', 'language')->findOrFail($id);
        return view('backend.layouts.song.show')->with($data);
    }

    public function edit($id)
    {
        $data['categories'] = SongCategory::all();
        $data['artists'] = Artist::all();
        $data['languages'] = Language::all();
        $data['song'] = Song::findOrFail($id);
        return view('backend.layouts.song.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'artist_id' => 'required',
            'song_category_id' => 'required',
            'language_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'audio' => 'nullable|file|mimetypes:audio/mp3,audio/mpeg,audio/wav,audio/ogg',

        ]);

        try {
            $data = Song::findOrFail($id);

            // image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = Helper::fileUploadStorage($image, 'song/image', $image->getClientOriginalName());

                if ($data->image) {
                    Helper::storageDeleteFile($data->image);
                }
            } else {
                $imagePath = $data->image;
            }

            // audio
            if ($request->hasFile('audio')) {
                $audio = $request->file('audio');
                $audioPath = Helper::fileUploadStorage($audio, 'song/audio', $audio->getClientOriginalName());

                if ($data->audio) {
                    Helper::storageDeleteFile($data->audio);
                }
            } else {
                $audioPath = $data->audio;
            }

            $data->artist_id = $request->artist_id;
            $data->language_id = $request->language_id;
            $data->song_category_id = $request->song_category_id;
            $data->title = $request->title;
            $data->short_description = $request->short_description;
            $data->difficult = $request->difficult;
            $data->image = $imagePath ?? $data->image;
            $data->audio = $audioPath ?? $data->audio;
            $data->save();

            return redirect()->route('song.index')->with('t-success', 'Song update successfully.');
        } catch (Exception $e) {
            return back()->with('t-success', 'Some thing went wrong while uploading your file.');
        }
    }

    public function destroy(int $id)
    {
        $user = Song::findOrFail($id);
        $user->delete();
        return response()->json([
            't-success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    // bulk delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Song::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message' => 'Selected data deleted successfully.'
        ]);
    }

    public function songDownload($id)
    {

    }
}
