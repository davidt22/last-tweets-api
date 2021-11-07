<?php

namespace App\Letgo\Infrastructure\Controller;

use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserRequest;
use App\Letgo\Application\Service\FindLastTweetsByUser\FindLastTweetsByUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ShoutController extends AbstractController
{
    const MAX_LIMIT = 10;

    public function index(
        FindLastTweetsByUserService $findLastTweetsByUserService,
        $twitterName,
        Request $request
    ): JsonResponse {
        try {
            $limit = self::MAX_LIMIT;

            if ($request->query->get('limit')) {
                $limit = $request->query->get('limit');
            }

            $findLastTweetsByUserRequest = new FindLastTweetsByUserRequest($twitterName, $limit);
            $tweets = $findLastTweetsByUserService->execute($findLastTweetsByUserRequest);

            return new JsonResponse($tweets);
        } catch (\Exception $exception) {
            $response = [
                'message' => $exception->getMessage()
            ];

            return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
