<?php

namespace App\Controller;

use App\PopularWord\PopularWordFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PopularWordController
 *
 * @package App\Controller
 *
 * Main controller that will handle getting word and score.
 */
class PopularWordController
{
    /**
     * @param PopularWordFetcherInterface $popularWordFetcher
     * @param Request                     $request
     *
     * @return JsonResponse
     */
    public function getScore(PopularWordFetcherInterface $popularWordFetcher, Request $request): JsonResponse
    {
        $term = $request->query->get('term');

        if (!$term) {
            return new JsonResponse(
                [
                    'errors' =>
                        [
                            'field' => 'term',
                            'status' => 'missing',
                        ],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            $popularWordFetcher->fetch($term)
        );
    }
}
