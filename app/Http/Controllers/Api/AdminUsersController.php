<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Interfaces\AdminUsersRepositoryInterface;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminUsersController extends Controller
{

    private $adminUserRepo;

    public function __construct(AdminUsersRepositoryInterface $adminUserRepo)
    {
        $this->adminUserRepo = $adminUserRepo;
    }

    public function list(Request $request)
    {

        $admin = auth('admin-api')->user();

        if (Gate::denies('view-users', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        $search = $request->search;

        $adminUsers = $this->adminUserRepo->getAll($search);
        $adminUsers->appends(['search' => $search]);


        $data = $adminUsers->map(function ($item) {
            return new UserResource($item);
        });



        return response()->json([
            'message' => '',
            'success' => true,
            'data' => $data,
            'pagination' => [
            'current_page' => $adminUsers->currentPage(),
            'per_page'     => $adminUsers->perPage(),
            'total'        => $adminUsers->total(),
            'last_page'    => $adminUsers->lastPage(),
           ],
        ]);

        

    }



    public function show(Admin $user)
    {

        $admin = auth('admin-api')->user();

        if (Gate::denies('view-users', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        return response()->json([
            'message' => '',
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }

    


    public function store(Request $request)
    {

         $admin = auth('admin-api')->user();

        if (Gate::denies('manage-users', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }


        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $data = collect($validatedData)->except('image')->toArray();    

        $adminUsers = $this->adminUserRepo->store($data);

         if ($request->has('image')) {
            $adminUsers->addMediaFromRequest('image')->toMediaCollection('admin-user-image');
         }


        return response()->json([
            'message' => 'Admin User Created Successfully',
            'success' => true,
            'data' => null,
        ]);

    }




    public function delete($id)
    {
        $this->adminUserRepo->delete($id);

        return response()->json([
            'message' => 'User Deleted Successfully',
            'success' => true,
            'data' => null,
        ]);

    }

}
