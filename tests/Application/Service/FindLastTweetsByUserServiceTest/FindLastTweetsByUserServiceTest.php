<?php

namespace App\Tests\Application\Service\FindLastTweetsByUserServiceTest;

use App\Letgo\Application\DataTransformer\Tweet\TweetDataTransformer;
use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserRequest;
use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserService;
use App\Letgo\Domain\Tweet\TweetLimitException;
use App\Letgo\Domain\Tweet\TweetRepository;
use App\Letgo\Domain\User\User;
use App\Letgo\Domain\User\UserId;
use App\Letgo\Domain\User\UserRepository;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

class FindLastTweetsByUserServiceTest extends TestCase
{
    /** @var TweetRepository */
    private $tweetRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TweetDataTransformer */
    private $tweetDataTransformer;

    /** @var CacheInterface */
    private $cache;

    /** @var FindLastTweetsByUserService */
    private $findLastTweetsByUserService;

    public function setUp(): void
    {
        parent::setUp();

        $this->tweetRepository = $this->createMock(TweetRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->tweetDataTransformer = $this->createMock(TweetDataTransformer::class);
        $this->cache = $this->createMock(CacheInterface::class);

        $this->findLastTweetsByUserService = new FindLastTweetsByUserService(
            $this->tweetRepository,
            $this->userRepository,
            $this->tweetDataTransformer,
            $this->cache
        );
    }

    public function testServiceReturnsData()
    {
        $username = 'test';
        $limit = 1;

        $this->tweetRepository
            ->method('searchByUser')
            ->willReturn(['tweet']);

        $request = new FindLastTweetsByUserRequest($username, $limit);
        $tweets = $this->findLastTweetsByUserService->execute($request);

        $this->assertCount($limit, $tweets);
    }

    public function testServiceReturnsEmptyData()
    {
        $username = 'test';
        $limit = 1;

        $this->tweetRepository
            ->method('searchByUser')
            ->willReturn([]);

        $request = new FindLastTweetsByUserRequest($username, $limit);
        $tweets = $this->findLastTweetsByUserService->execute($request);

        $this->assertCount(0, $tweets);
    }

    public function testServiceThrowsLimitException()
    {
        $this->expectException(TweetLimitException::class);

        $username = 'test';
        $limit = 11;

        $this->tweetRepository
            ->method('searchByUser')
            ->willThrowException(new TweetLimitException(''));

        $request = new FindLastTweetsByUserRequest($username, $limit);
        $this->findLastTweetsByUserService->execute($request);
    }

    public function testServiceCachesData()
    {
        $this->cache
            ->method('has')
            ->willReturn(true);
        $this->cache
            ->method('get')
            ->willReturn(['test-cached']);

        $username = 'test';
        $limit = 11;

        $request = new FindLastTweetsByUserRequest($username, $limit);
        $tweetsCached = $this->findLastTweetsByUserService->execute($request);

        $this->assertEquals('test-cached', $tweetsCached[0]);
    }
}