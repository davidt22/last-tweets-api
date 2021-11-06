<?php

namespace App\Letgo\Infrastructure\Controller;

use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserRequest;
use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShoutController extends AbstractController
{
    public function index(
        FindLastTweetsByUserService $findLastTweetsByUserService,
        $twitterName,
        $limit
    ): JsonResponse {
        try {
            $findLastTweetsByUserRequest = new FindLastTweetsByUserRequest($twitterName, $limit);
            $tweets = $findLastTweetsByUserService->execute($findLastTweetsByUserRequest);

            return new JsonResponse($tweets);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $response = [
                'message' => $message
            ];

            return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
