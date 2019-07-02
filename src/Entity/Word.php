<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Word
 *
 * @ORM\Table(name="word", indexes={@ORM\Index(name="search_idx", columns={"term"})})
 * @ORM\Entity
 */
class Word
{
    public const FETCH_RESOURCE_GIT_HUB = 1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Term that we're searching for.
     *
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=255, nullable=false)
     */
    private $term;

    /**
     * @var int
     *
     * @ORM\Column(name="positive_occurrences", type="integer", length=45, nullable=false)
     */
    private $positiveOccurrences;

    /**
     * @var int
     *
     * @ORM\Column(name="negative_occurrences", type="integer", length=45, nullable=false)
     */
    private $negativeOccurrences;

    /**
     * @var int
     *
     * @ORM\Column(name="fetch_resource", type="integer", length=1, nullable=false)
     */
    private $fetchResource;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts_insert", type="date", nullable=false)
     */
    private $tsInsert;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ts_update", type="date", nullable=true)
     */
    private $tsUpdate;

    /**
     * Word constructor.
     *
     * @param string $term
     * @param int    $positiveOccurrences
     * @param int    $negativeOccurrences
     * @param int    $fetchResource
     */
    public function __construct(string $term, int $positiveOccurrences, int $negativeOccurrences, int $fetchResource)
    {
        $this->term = $term;
        $this->positiveOccurrences = $positiveOccurrences;
        $this->negativeOccurrences = $negativeOccurrences;
        $this->fetchResource = $fetchResource;
        $this->tsInsert = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->tsUpdate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getPositiveOccurrences(): int
    {
        return $this->positiveOccurrences;
    }

    /**
     * @return int
     */
    public function getNegativeOccurrences(): int
    {
        return $this->negativeOccurrences;
    }

    /**
     * @return int
     */
    public function getFetchResource(): int
    {
        return $this->fetchResource;
    }

    /**
     * @return \DateTime
     */
    public function getTsInsert(): \DateTime
    {
        return $this->tsInsert;
    }

    /**
     * @return \DateTime|null
     */
    public function getTsUpdate(): ?\DateTime
    {
        return $this->tsUpdate;
    }
}
