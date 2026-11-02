<?php

namespace App\Http\Controllers\Web\Backend\User;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index(Request $request): JsonResponse | View
    {
        if ($request->ajax()) {
            $data = User::latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('avatar', function ($data) {
                    $defaultImage = asset('frontend/default-avatar-profile.jpg');
                    $url = $data->avatar ? url(Storage::url($data->avatar)) : $defaultImage;

                    return '<img src="' . $url . '" alt="Avatar" width="50" height="50" style="object-fit:cover; border-radius:50%;">';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('user.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary-gradient fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $row->id . '">';
                })
                ->rawColumns(['avatar', 'action', 'checkbox'])
                ->make();
        }
        return view('backend.layouts.user.index');
    }

    public function create()
    {
        return view('backend.layouts.user.create');
    }

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:100',
                'email'     => 'required|string|email|unique:users,email',
                'password'  => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $filePath = null;
            if ($request->file('avatar')) {
                $filePath = Helper::fileUploadStorage($request->file('avatar'),'users',
                    $request->name   // string
                );
            }

            $data                       = new User();
            $data->name                 = $request->name;
            $data->email                = $request->email;
            $data->role                 = $request->role;
            $data->password             = Hash::make($request->password);
            $data->avatar               = $filePath;
            $data->save();


            return redirect()->route('user.index')->with('t-success', 'User create successfully');
        } catch (Exception $e) {
            return redirect()->route('user.index')->with('t-success', 'User failed created.');
        }
    }

    public function edit(int $id): View
    {
        $data = User::findOrFail($id);
        return view('backend.layouts.user.edit', compact('data'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $data = User::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name'  => 'nullable|string|max:100',
                'email' => 'nullable|string|email|unique:users,email,' . $id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle avatar upload
            if ($request->file('avatar')) {

                $filePath = Helper::fileUploadStorage($request->file('avatar'), 'users', $request->name);
                if ($data->avatar) {
                    Helper::storageDeleteFile($data->avatar);
                }
            } else {
                $filePath = $data->avatar;
            }

            $data->name     = $request->name ?? $data->name;
            $data->email    = $request->email ?? $data->email;
            $data->role     = $request->role ?? $data->role;
            $data->avatar   = $filePath;
            $data->password = Hash::make($request->password) ?? $data->password;
            $data->update();
            return redirect()->route('user.index')->with('t-success', 'User info Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('user.index')->with('t-success', 'User info failed to update');
        }
    }


    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
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
        User::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Selected songs deleted successfully.'
        ]);
    }

}
