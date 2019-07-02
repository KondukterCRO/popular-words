<?php

namespace App\PopularWord;

use App\PopularWord\Model\PopularWord;

/**
 * Interface WordPopularityGeneratorInterface
 *
 * @package App\PopularWord
 *
 * Base class that will give popularity for given word.
 */
interface WordPopularityGeneratorInterface
{
    /**
     * Fetch db or external resource for given term with {positive_suffix} and {negative_suffix}.
     * Ratio between occurrences of {word} {positive_suffix} and total occurrences will give score.
     * If fetched from external resource it will be added to db.
     *
     * @param string $term
     *
     * @return PopularWord
     */
    public function generate(string $term): PopularWord;

    /**
     * Get positive suffix for external resource.
     *
     * @return string
     */
    public function positiveSuffix(): string;

    /**
     * Get negative suffix for external resource.
     *
     * @return string
     */
    public function negativeSuffix(): string;
}
