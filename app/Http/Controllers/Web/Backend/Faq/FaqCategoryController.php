<?php

namespace App\Http\Controllers\Web\Backend\Faq;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FaqCategoryController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FaqCategory::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "Active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "Active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('faq.category.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make();
        }
        return view('backend.layouts.faq-category.index');
    }

    public function status(int $id): JsonResponse {
        $data = FaqCategory::findOrFail($id);

        if ($data->status == 'Active') {
            $data->status = 'Inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'Active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

    public function create()
    {
        return view('backend.layouts.faq-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:faq_categories,name',
        ]);

        FaqCategory::create($request->all());

        return redirect()->route('faq.category.index')->with('t-success','Faq category created successfully');
    }

    public function edit($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        return view('backend.layouts.faq-category.edit', compact('faqCategory'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $faqCategory = FaqCategory::findOrFail($id);
            $faqCategory->update($request->all());

            return redirect()->route('faq.category.index')->with('t-success','Faq category updated successfully');

        }catch (\Exception $exception){
            return redirect()->back()->with('t-error',$exception->getMessage());
        }
    }

    public function destroy($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        $faqCategory->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }
}

