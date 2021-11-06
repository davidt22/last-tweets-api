<?php

namespace App\Letgo\Application\Service\FindLastTweetsByUser;

use App\Letgo\Application\ApplicationService;
use App\Letgo\Application\DataTransformer\Tweet\TweetDataTransformer;
use App\Letgo\Application\RequestInterface;
use App\Letgo\Domain\Tweet\Tweet;
use App\Letgo\Domain\Tweet\TweetRepository;
use App\Letgo\Domain\User\UserRepository;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class FindLastTweetsByUserService implements ApplicationService
{
    const CACHE_KEY = 'tweets-';
    const CACHE_TIME = 3600;

    /** @var TweetRepository */
    private $tweetRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TweetDataTransformer */
    private $tweetDataTransformer;

    /** @var CacheInterface */
    private $cache;

    public function __construct(
        TweetRepository $tweetRepository,
        UserRepository $userRepository,
        TweetDataTransformer $tweetDataTransformer,
        CacheInterface $cache
    ) {
        $this->tweetRepository = $tweetRepository;
        $this->userRepository = $userRepository;
        $this->tweetDataTransformer = $tweetDataTransformer;
        $this->cache = $cache;
    }

    /**
     * @param RequestInterface|FindLastTweetsByUserRequest $request
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function execute(RequestInterface $request): array
    {
        $key = self::CACHE_KEY.$request->username();

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $user = $this->userRepository->findByUserNameOrFail($request->username());
        $tweets = $this->tweetRepository->searchByUser($user, $request->limit());

        return $this->getTweetsTransformed($tweets, $key);
    }

    /**
     * @param array  $tweets
     * @param string $key
     *
     * @return array
     * @throws InvalidArgumentException
     */
    private function getTweetsTransformed(array $tweets, string $key): array
    {
        $tweetsTransformed = [];
        /** @var Tweet $tweet */
        foreach ($tweets as $tweet) {
            $this->tweetDataTransformer->write($tweet);
            $tweetsTransformed[] = $this->tweetDataTransformer->read();
        }

        $this->cache->set($key, $tweetsTransformed, self::CACHE_TIME);

        return $tweetsTransformed;
    }
}