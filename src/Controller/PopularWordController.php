<?php

namespace App\Controller;

use App\PopularWord\PopularWordFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PopularWordController
 *
 * @package App\Controller
 *
 * Main controller that will handle getting word and score.
 */
class PopularWordController
{
    public function getScore(PopularWordFetcherInterface $popularWordFetcher): JsonResponse
    {
        return new JsonResponse($popularWordFetcher->fetch());
    }
}
