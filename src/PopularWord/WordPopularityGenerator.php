<?php

namespace App\PopularWord;

use App\Entity\Word;
use App\PopularWord\Model\PopularWord;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class WordPopularityGenerator
 *
 * @package App\PopularWord
 *
 * Class responsible for fetching external resource or db for word popularity and returning score.
 */
final class WordPopularityGenerator implements WordPopularityGeneratorInterface
{
    /** @var PopularWordFetcherInterface */
    private $popularWordFetcher;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** {@inheritdoc} */
    public function positiveSuffix(): string
    {
        return 'rocks';
    }

    /** {@inheritdoc} */
    public function negativeSuffix(): string
    {
        return 'sucks';
    }

    /**
     * Score will be between 0 and 10.
     *
     * {@inheritdoc}
     */
    public function generate(string $term): PopularWord
    {
        $popularWord = $this->entityManager
            ->getRepository(Word::class)
            ->findOneBy(['term' => $term]);

        // already stored in db
        if ($popularWord) {
            return new PopularWord($term, $this->generateScore($popularWord));
        }

        $wordPositiveOccurrences = $this->popularWordFetcher->fetch(urlencode("{$term} {$this->positiveSuffix()}"));
        $wordNegativeOccurrences = $this->popularWordFetcher->fetch(urlencode("{$term} {$this->negativeSuffix()}"));

        $popularWord = new Word(
            $term,
            $wordPositiveOccurrences->getOccurrences(),
            $wordNegativeOccurrences->getOccurrences(),
            Word::FETCH_RESOURCE_GIT_HUB
        );

        $this->entityManager->persist($popularWord);
        $this->entityManager->flush();

        return new PopularWord($term, $this->generateScore($popularWord));
    }

    /**
     * WordPopularityGenerator constructor.
     *
     * @param PopularWordFetcherInterface $popularWordFetcher
     * @param EntityManagerInterface      $entityManager
     */
    public function __construct(PopularWordFetcherInterface $popularWordFetcher, EntityManagerInterface $entityManager)
    {
        $this->popularWordFetcher = $popularWordFetcher;
        $this->entityManager = $entityManager;
    }

    /**
     * Generate score from 0 - 10 based on positive and negative occurrences.
     *
     * @param Word $word
     *
     * @return float
     */
    private function generateScore(Word $word): float
    {
        return round(($word->getPositiveOccurrences() /
                ($word->getPositiveOccurrences() + $word->getNegativeOccurrences())) *
            10, 2);
    }
}
