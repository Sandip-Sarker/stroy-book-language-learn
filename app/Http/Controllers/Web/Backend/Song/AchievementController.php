<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Artist;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AchievementController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Achievement::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $defaultImage = asset($data->image);
                    $url = $data->image ? url(Storage::url($data->image)) : $defaultImage;
                    return '<img src="' . $url . '" alt="Avatar" width="50" height="50" style="object-fit:cover; border-radius:50%;">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                     <button class="btn btn-primary-gradient" onclick="openEditModal('.$data->id.')">
                                        <i class="fe fe-edit"></i>
                                    </button>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $row->id . '">';
                })
                ->rawColumns(['action', 'checkbox', 'image'])
                ->make();
        }
        return view('backend.layouts.achievement.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'image'     => 'required',
            'xp_num'    => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = Helper::fileUploadStorage($image, 'achievement/image', $image->getClientOriginalName());
        }

        $data           = new Achievement();
        $data->title    = $request->title;
        $data->image    = $imagePath ?? null;
        $data->quiz_num = $request->input('quiz_num', 0);
        $data->xp_num   = $request->xp_num;
        $data->save();

        return response()->json([
            'message' => 'Data Create successfully'
        ]);
    }

    public function edit($id)
    {
        $data = Achievement::findOrFail($id);

        $imageUrl = $data->image ? url(Storage::url($data->image)) : '';

        return response()->json([
            'id'        => $data->id,
            'title'     => $data->title,
            'image'     => $imageUrl,
            'xp_num'    => $data->xp_num,
            'quiz_num'  => $data->quiz_num,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'required',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'xp_num'    => 'required',
        ]);

        $data =  Achievement::find($id);

        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = Helper::fileUploadStorage($image, 'achievement/image', $image->getClientOriginalName());

            if ($data->image) {
                Helper::storageDeleteFile($data->image);
            }
        } else {
            $imagePath = $data->image;
        }

        $data->title    = $request->title;
        $data->image    = $imagePath;
        if ($request->has('quiz_num')) {
            $data->quiz_num = $request->quiz_num;
        }
        $data->xp_num   = $request->xp_num;
        $data->save();

        return response()->json([
            'message' => 'Data updated successfully'
        ]);
    }


    public function destroy(int $id)
    {
        $user = Achievement::findOrFail($id);
        $user->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }

    // bulk delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Achievement::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Selected data deleted successfully.'
        ]);
    }
}
