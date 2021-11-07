<?php

namespace App\Letgo\Infrastructure\Persistence;


use App\Letgo\Domain\User\User;
use App\Letgo\Domain\User\UserId;
use App\Letgo\Domain\User\UserNotFoundException;
use App\Letgo\Domain\User\UserRepository;

final class UserRepositoryInMemory implements UserRepository
{
    private $users = [];

    public function __construct()
    {
        $this->users[] = new User($this->nextIdentity(), 'realDonaldTrump', 'Dondald Trump', []);
    }

    public function nextIdentity(): UserId
    {
        return new UserId();
    }

    /**
     * @throws UserNotFoundException
     */
    public function findByUserNameOrFail(string $username): User
    {
        /** @var User $user */
        foreach ($this->users as $user) {
            if ($user->username() === $username) {
                return $user;
            }
        }

        throw new UserNotFoundException($username);
    }
}
