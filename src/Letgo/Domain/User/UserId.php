<?php

namespace App\Letgo\Domain\User;

use Ramsey\Uuid\Uuid;

class UserId
{
    /** @var string */
    private $id;

    public function __construct(string $id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id();
    }
}