<?php

namespace App\Repositories;

use App\Interfaces\AdminUsersRepositoryInterface;
use App\Models\Admin;
use App\Models\Product;

class AdminUsersRepository implements AdminUsersRepositoryInterface 
{

    public function getAll($search = null)
    {
        $query = Admin::with('role.permissions')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate(10);
    }


    public function find($id)
    {
        $adminUser = Admin::findOrFail($id);

        return $adminUser;
    }

    public function store($data)
    {
        return Admin::create($data);
    }


    public function update($data)
    {
        $adminUser = $this->find($data['id']);

        if (!$adminUser){
            return null;
        }

        $adminUser->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $data['role_id']
        ]);

        return $adminUser;
    }


    public function delete($id)
    {
        $adminUser = $this->find($id);

        if (!$adminUser) {
                return false;
            }

        $adminUser->clearMediaCollection('admin-user-image');

        return $adminUser->delete();
    }

}