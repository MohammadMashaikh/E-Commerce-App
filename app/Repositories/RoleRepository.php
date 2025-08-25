<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface {


    public function getAll($search = null)
    {
        $query = Role::with('admins', 'permissions')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('admins', function ($q1) use ($search) {
                    $q1->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('permissions', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        return $query->paginate(10);
    }


    public function find($id)
    {
        $role = Role::findOrFail($id);

        return $role;
    }

    public function store($data)
    {
        return Role::create($data);
    }

    public function update($data)
    {
        $role = $this->find($data['id']);

        if (!$role){
            return null;
        }

        $role->update([
            'name' => $data['name'],
        ]);

        return $role;
    }

    public function delete($id)
    {
        $role = $this->find($id);

        if (!$role) {
             return false;
        }

        return $role->delete();
    }

}