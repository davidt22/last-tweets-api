<?php

namespace App\Letgo\Application\DataTransformer;

interface DataTransformer
{
    public function read();

    public function write($object);
}