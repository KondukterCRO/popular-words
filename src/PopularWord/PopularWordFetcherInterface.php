<?php

namespace App\PopularWord;

use App\PopularWord\Model\SearchTerm;

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
     * Fetch occurrences of given string from external service and return model of it.
     *
     * @param string $term
     *
     * @return SearchTerm
     */
    public function fetch(string $term): SearchTerm;
}
