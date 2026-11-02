<?php

namespace App\Http\Controllers\Web\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FunFact;
use Exception;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;

class FunFactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FunFact::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("language", function ($data) {
                    return $data->language ? $data->language->name : 'N/A';
                })
                ->addColumn('image', function ($data) {
                    $url = $data->image ? Storage::url($data->image) : asset('backend/images/no-image.png');
                    return '<img src="' . $url . '" alt="image" class="img-fluid rounded" style="width: 50px; height: 50px;">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group">
                                <button onclick="openEditModal(' . $data->id . ')" class="btn btn-primary-gradient fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </button>
                                <button onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </button>
                            </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $row->id . '">';
                })
                ->editColumn('description', function ($data) {
                    return Str::limit(strip_tags($data->description), 50);
                })
                ->rawColumns(['image', 'action', 'checkbox', 'language'])
                ->make(true);
        }

        $languages = Language::all();
        return view('backend.layouts.fun-fact.index', compact('languages'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'language_id' => 'required|exists:languages,id',  // এটা add করুন
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = $request->except('image');
            
            if ($request->hasFile('image')) {
                $data['image'] = Helper::fileUploadStorage($request->file('image'), 'fun-fact', $request->title);
            }

            FunFact::create($data);
            return response()->json(['success' => true, 'message' => 'Fun Fact created successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create Fun Fact.']);
        }
    }


    public function edit($id)
    {
        try {
            $funFact = FunFact::findOrFail($id);
            return response()->json($funFact);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Fun Fact not found.']);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'language_id' => 'required|exists:languages,id',  // এটা add করুন
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $funFact = FunFact::findOrFail($id);
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                // Delete old image
                Helper::storageDeleteFile($funFact->image);

                $data['image'] = Helper::fileUploadStorage($request->file('image'), 'fun-fact', $request->title);
            }

            $funFact->update($data);
            return response()->json(['success' => true, 'message' => 'Fun Fact updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update Fun Fact.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $funFact = FunFact::findOrFail($id);
            
            // Delete associated image
            Helper::storageDeleteFile($funFact->image);
            
            $funFact->delete();
            return response()->json(['success' => true, 'message' => 'Fun Fact deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Fun Fact.']);
        }
    }
}
