<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    private $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    
    public function list(Request $request)
    {
        $search = $request->search;

        $roles = $this->roleRepo->getAll($search);
        $roles->appends(['search' => $search]);


        return view('admin.roles.index', compact('roles'));
    }



    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }



    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $data = collect($validatedData)->toArray();    

        $role = $this->roleRepo->store($data);


        if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
           }
                

        return redirect()->route('admin.roles.list')->with('success', 'Role and Permissions Added Successfully');

    }



    public function edit()
    {
        return view('admin.users.edit');
    }


    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

            if (!empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

        $data = collect($validatedData)->except('image')->toArray();
        $data['id'] = $id;
        
        $adminUsers = $this->roleRepo->update($data);

        if (!$adminUsers) {
            return redirect()->back()->with('error', 'User not found.');
        }


         if ($request->hasFile('image')) {
            $adminUsers->clearMediaCollection('admin-user-image');
            $adminUsers->addMediaFromRequest('image')->toMediaCollection('admin-user-image');
        }


        return redirect()->route('admin.users.list')->with('success', 'User Updated Successfully');
    }




    public function delete($id)
    {
        $this->roleRepo->delete($id);
        return redirect()->back()->with('success', 'User Deleted Successfully');

    }
}
