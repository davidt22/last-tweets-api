<?php

namespace App\Letgo\Application\Service\FindLastTweetsByUser;

use App\Letgo\Application\RequestInterface;

class FindLastTweetsByUserRequest implements RequestInterface
{
    /** @var string */
    private $username;

    /** @var int */
    private $limit;

    public function __construct(string $username, int $limit)
    {
        $this->username = $username;
        $this->limit = $limit;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}