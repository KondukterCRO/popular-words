<?php

namespace App\Controller;

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
    public function getScore(): JsonResponse
    {
        return new JsonResponse();
    }
}
