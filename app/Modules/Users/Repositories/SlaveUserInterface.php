<?php
namespace App\Modules\Users\Repositories;

interface SlaveUserInterface
{
    public function find($id);
    public function create($attributes);
    public function update($id, $attributes);
    public function delete($id);
    public function findBy($key, $value);
    public function restore($id);
    public function auth();
}