<?php

namespace App\PopularWord;

use App\PopularWord\Model\PopularWord;

/**
 * Interface PopularWordFetcherInterface
 *
 * @package App\PopularWord
 *
 * Base class that can fetch popular word from external service.
 */
interface PopularWordFetcherInterface
{
    /**
     * Fetch popular word from external service and return model of it.
     *
     * @return PopularWord
     */
    public function fetch(): PopularWord;
}
