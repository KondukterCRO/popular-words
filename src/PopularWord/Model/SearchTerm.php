<?php

namespace App\PopularWord\Model;

/**
 * Class SearchTerm
 *
 * @package App\PopularWord\Model
 *
 * Class that represents search term wit number of occurrences
 * returned by our API.
 */
class SearchTerm
{
    /**
     * Term that we're searching for.
     *
     * @var string
     */
    private $term;

    /**
     * Occurrences for searched term.
     *
     * @var int
     */
    private $occurrences;

    /**
     * SearchTerm constructor.
     *
     * @param string $term
     * @param int  $occurrences
     */
    public function __construct(string $term, int $occurrences)
    {
        $this->term = $term;
        $this->occurrences = $occurrences;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @return int
     */
    public function getOccurrences(): int
    {
        return $this->occurrences;
    }
}
