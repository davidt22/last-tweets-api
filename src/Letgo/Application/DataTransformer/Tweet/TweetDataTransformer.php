<?php

namespace App\Letgo\Application\DataTransformer\Tweet;

use App\Letgo\Application\DataTransformer\DataTransformer;
use App\Letgo\Domain\Tweet\Tweet;

class TweetDataTransformer implements DataTransformer
{
    /** @var Tweet */
    private $tweet;

    public function read(): string
    {
        $lastCharacter = substr($this->tweet->text(), -1);

        if ($lastCharacter != '!') {
            $text = $this->tweet->text();
            $this->tweet->setText($text .= '!');
        }

        return strtoupper($this->tweet->text());
    }

    /**
     * @param Tweet $object
     */
    public function write($object)
    {
        $this->tweet = $object;
    }
}