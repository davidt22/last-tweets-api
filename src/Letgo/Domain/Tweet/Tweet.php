<?php

namespace App\Letgo\Domain\Tweet;

use App\Letgo\Domain\User\User;
use App\Letgo\Domain\User\UserId;

final class Tweet
{
    /** @var TweetId */
    private $id;

    /** @var User */
    private $user;

    /** @var string */
    private $text;

    public function __construct(TweetId $id, User $user, string $text)
    {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
    }

    public function id(): TweetId
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
