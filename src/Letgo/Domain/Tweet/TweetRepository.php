<?php

namespace App\Letgo\Domain\Tweet;

use App\Letgo\Domain\User\User;

interface TweetRepository
{
    public function nextIdentity();
    public function searchByUser(User $user, int $limit): array;
}
