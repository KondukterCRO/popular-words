<?php

namespace App\Controller;

use App\PopularWord\WordPopularityGenerator;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @param WordPopularityGenerator $wordPopularityGenerator
     * @param Request                 $request
     *
     * @return JsonResponse
     */
    public function getScore(WordPopularityGenerator $wordPopularityGenerator, Request $request): JsonResponse
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

        try {
            $popularWord = $wordPopularityGenerator->generate($term);
        } catch (\RuntimeException $runtimeException) {
            return new JsonResponse(
                [
                    'errors' =>
                        [
                            'content' => 'not found',
                        ],
                ],
                JsonResponse::HTTP_NO_CONTENT
            );
        }

        return new JsonResponse(
            $popularWord
        );
    }
}
