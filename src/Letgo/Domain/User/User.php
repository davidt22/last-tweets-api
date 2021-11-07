<?php

namespace App\Letgo\Domain\User;

use App\Letgo\Domain\Tweet\Tweet;

class User
{
    /** @var UserId */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $name;

    /** @var Tweet[] */
    private $tweets;

    public function __construct(UserId $id, string $username, string $name, array $tweets)
    {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->tweets = $tweets;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function tweets(): array
    {
        return $this->tweets;
    }
}