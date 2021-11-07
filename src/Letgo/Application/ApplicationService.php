<?php

namespace App\Letgo\Application;

interface ApplicationService
{
    public function execute(RequestInterface $request);
}