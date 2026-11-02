<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Language::latest()
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
        return view('backend.layouts.language.index');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = Helper::fileUploadStorage($image, 'language/image', $image->getClientOriginalName());
        }

        $language           = new Language();
        $language->name     = $request->name;
        $language->image    = $imagePath;
        $language->save();

        return response()->json([
            'message' => 'Language Create successfully'
        ]);
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);

        $imageUrl = $language->image ? asset(Storage::url($language->image)) : '';

        return response()->json([
            'id'   => $language->id,
            'name' => $language->name,
            'image' => $imageUrl,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $data = Language::find($id);

        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = Helper::fileUploadStorage($image, 'language/image', $image->getClientOriginalName());

            if ($data->image) {
                Helper::storageDeleteFile($data->image);
            }
        } else {
            $imagePath = $data->image;
        }

        $data->name     = $request->name;
        $data->image    = $imagePath;
        $data->save();


        return response()->json([
            'message' => 'Language updated successfully'
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $user = Language::findOrFail($id);
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
        Language::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Selected data deleted successfully.'
        ]);
    }
}
