<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AdminUsersRepositoryInterface;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{

     private $adminUserRepo;

    public function __construct(AdminUsersRepositoryInterface $adminUserRepo)
    {
        $this->adminUserRepo = $adminUserRepo;
    }

    public function list(Request $request)
    {
        $search = $request->search;

        $adminUsers = $this->adminUserRepo->getAll($search);
        $adminUsers->appends(['search' => $search]);

        

        return view('admin.users.index', compact('adminUsers'));
    }



    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('admin.users.create', compact('roles'));
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $data = collect($validatedData)->except('image')->toArray();    

        $adminUsers = $this->adminUserRepo->store($data);

         if ($request->has('image')) {
            $adminUsers->addMediaFromRequest('image')->toMediaCollection('admin-user-image');
         }


        return redirect()->route('admin.users.list')->with('success', 'User Added Successfully');

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
        
        $adminUsers = $this->adminUserRepo->update($data);

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
        $this->adminUserRepo->delete($id);
        return redirect()->back()->with('success', 'User Deleted Successfully');

    }


}
