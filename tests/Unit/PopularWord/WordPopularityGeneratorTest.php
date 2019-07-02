<?php

namespace App\Tests\Unit\PopularWord;

use App\Entity\Word;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\PopularWord\Model\SearchTerm;
use App\PopularWord\Model\PopularWord;
use App\PopularWord\GitHubIssueFetcher;
use App\PopularWord\WordPopularityGenerator;

/**
 * Class WordPopularityGeneratorTest
 *
 * @package App\Tests\Unit\PopularWord
 *
 * Test correct word generating.
 */
class WordPopularityGeneratorTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $popularWordFetcher;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $entityRepository;

    /** @var WordPopularityGenerator */
    private $wordPopularityGenerator;

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->popularWordFetcher = $this->getMockBuilder(GitHubIssueFetcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->wordPopularityGenerator = new WordPopularityGenerator(
            $this->popularWordFetcher,
            $this->entityManager
        );
    }

    /**
     * @covers WordPopularityGenerator::generate()
     */
    public function testWhenWordFoundInDatabase()
    {
        $this->entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));

        $term = 'foo';

        $word = new Word($term, 20, 80, Word::FETCH_RESOURCE_GIT_HUB);

        $this->entityRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($word));

        $this->entityManager
            ->expects($this->never())
            ->method('persist');

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->popularWordFetcher
            ->expects($this->never())
            ->method('fetch');

        $popularWord = new PopularWord($term, 2.0);

        $this->assertEquals($popularWord, $this->wordPopularityGenerator->generate($term));

    }

    /**
     * @covers WordPopularityGenerator::generate()
     */
    public function testWhenWordNotFoundInDatabase()
    {
        $this->entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));

        $term = 'foo';

        $this->entityRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this->entityManager
            ->expects($this->once())
            ->method('persist');

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->popularWordFetcher
            ->expects($this->exactly(2))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(new SearchTerm($term, 50), new SearchTerm($term, 50));

        $popularWord = new PopularWord($term, 5.0);

        $this->assertEquals($popularWord, $this->wordPopularityGenerator->generate($term));

    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->entityManager = null;
        $this->popularWordFetcher = null;
        $this->entityRepository = null;
        $this->wordPopularityGenerator = null;
    }
}
