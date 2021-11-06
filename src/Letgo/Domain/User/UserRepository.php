<?php

namespace App\Letgo\Domain\User;

interface UserRepository
{
    public function nextIdentity();
    public function findByUserNameOrFail(string $username): User;
}
