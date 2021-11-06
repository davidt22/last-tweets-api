<?php

namespace App\Letgo\Application\Service\FindLastTweetsByUser;

use App\Letgo\Application\ApplicationService;
use App\Letgo\Application\DataTransformer\Tweet\TweetDataTransformer;
use App\Letgo\Application\RequestInterface;
use App\Letgo\Domain\Tweet\Tweet;
use App\Letgo\Domain\Tweet\TweetRepository;
use App\Letgo\Domain\User\UserRepository;

class FindLastTweetsByUserService implements ApplicationService
{
    /** @var TweetRepository */
    private $tweetRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var TweetDataTransformer */
    private $tweetDataTransformer;

    public function __construct(
        TweetRepository $tweetRepository,
        UserRepository $userRepository,
        TweetDataTransformer $tweetDataTransformer
    ) {
        $this->tweetRepository = $tweetRepository;
        $this->userRepository = $userRepository;
        $this->tweetDataTransformer = $tweetDataTransformer;
    }

    /**
     * @param RequestInterface|FindLastTweetsByUserRequest $request
     */
    public function execute(RequestInterface $request): array
    {
        $user = $this->userRepository->findByUserNameOrFail($request->username());
        $tweets = $this->tweetRepository->searchByUser($user, $request->limit());

        $tweetsTransformed = [];
        /** @var Tweet $tweet */
        foreach ($tweets as $tweet) {
            $this->tweetDataTransformer->write($tweet);
            $tweetsTransformed[] = $this->tweetDataTransformer->read();
        }

        return $tweetsTransformed;
    }
}