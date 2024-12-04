<?php

namespace App\Http\Services;

use App\Models\User;
use App\Http\Repositories\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

}
