<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(private readonly User $model)
    {
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function getById(int $id): User
    {
        return $this->model->find($id);
    }
}
