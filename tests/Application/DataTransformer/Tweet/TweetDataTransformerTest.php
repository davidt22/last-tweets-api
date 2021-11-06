<?php

namespace App\Tests\Application\DataTransformer\Tweet;

use App\Letgo\Application\DataTransformer\Tweet\TweetDataTransformer;
use App\Letgo\Domain\Tweet\Tweet;
use App\Letgo\Domain\Tweet\TweetId;
use App\Letgo\Domain\User\User;
use PHPUnit\Framework\TestCase;

class TweetDataTransformerTest extends TestCase
{
    /** @var TweetDataTransformer */
    private $tweetDataTransformer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tweetDataTransformer = new TweetDataTransformer();
    }

    public function testItTransformsTweet()
    {
        $user = $this->createMock(User::class);
        $tweet = new Tweet(new TweetId(), $user, 'text');
        $this->tweetDataTransformer->write($tweet);

        $assignedTweet = $this->tweetDataTransformer->read();

        $this->assertEquals('TEXT!', $assignedTweet);
    }

    public function testItReturnsEmptyData()
    {
        $assignedTweet = $this->tweetDataTransformer->read();

        $this->assertEmpty($assignedTweet);
    }
}