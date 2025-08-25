<?php

namespace App\Interfaces;

interface AdminUsersRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function store($data);
    public function update($data);
    public function delete($id);
}
