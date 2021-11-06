<?php

namespace App\Letgo\Domain\User;

class UserNotFoundException extends \Exception
{
    public function __construct(string $username)
    {
        parent::__construct('User '.$username.' not found.');
    }
}