<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\Page;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PageSettingController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse | View
    {
        if ($request->ajax()) {
            $data = DynamicPage::latest()->get();

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
                                <a href="' . route('page.setting.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                              
                            </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make();
        }
        return view('backend.layouts.page.index');
    }

    public function status(int $id): JsonResponse {
        $data = DynamicPage::findOrFail($id);

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
        return view('backend.layouts.page.create');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'page_title' => 'required',
                'page_slug'  => 'required',
            ]);
            DynamicPage::create($request->all());

            return redirect()->route('page.setting')->with('t-success', 'Page created successfully');
        }catch (\Exception $exception){
            return redirect()->route('page.setting')->with('t-error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $data = DynamicPage::find($id);
        return view('backend.layouts.page.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required',
            'page_slug'  => 'required',
        ]);

        $data = DynamicPage::find($id);

        if ($data) {
            $data->update($request->all());
            return redirect()->route('page.setting')->with('t-success', 'Page updated successfully');
        }

        return redirect()->route('page.setting')->with('t-error', 'Something went wrong');
    }

    public function destroy($id)
    {
        $user = DynamicPage::findOrFail($id);
        $user->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }
}
