<?php

namespace App\Http\Controllers\Web\Backend\Song;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ArtistController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Artist::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
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
                ->rawColumns(['action', 'checkbox'])
                ->make();
        }
        return view('backend.layouts.artist.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Artist::create($request->all());

        return response()->json([
            'message' => 'Language Create successfully'
        ]);
    }

    public function edit($id)
    {
        $language = Artist::findOrFail($id);

        return response()->json([
            'id'   => $language->id,
            'name' => $language->name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Artist::where('id', $id)->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Language updated successfully'
        ]);
    }


    public function destroy(int $id)
    {
        $user = Artist::findOrFail($id);
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
        Artist::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Selected data deleted successfully.'
        ]);
    }
}
