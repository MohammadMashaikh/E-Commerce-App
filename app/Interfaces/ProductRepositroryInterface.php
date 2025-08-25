<?php

namespace App\Interfaces;

interface ProductRepositroryInterface
{
    public function getAll();
    public function getAllFiltered();
    public function find($id);
    public function store($data);
    public function update($data);
    public function delete($id);
}
