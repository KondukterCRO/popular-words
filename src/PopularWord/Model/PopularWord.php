<?php

namespace App\PopularWord\Model;

/**
 * Class PopularWord
 *
 * @package App\PopularWord\Model
 *
 * Class that represents popular word returned by our API.
 */
class PopularWord implements \JsonSerializable
{
    /**
     * Term that we're searching for.
     *
     * @var string
     */
    private $term;

    /**
     * Score for searched term.
     *
     * @var float
     */
    private $score;

    /** {@inheritdoc} */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * PopularWord constructor.
     *
     * @param string $term
     * @param float  $score
     */
    public function __construct(string $term, float $score)
    {
        $this->term = $term;
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }
}
