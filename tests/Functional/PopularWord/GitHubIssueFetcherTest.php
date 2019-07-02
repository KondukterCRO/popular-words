<?php

namespace App\Tests\Functional\PopularWord;

use App\PopularWord\Model\PopularWord;
use App\PopularWord\GitHubIssueFetcher;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GitHubIssueFetcherTest
 *
 * @package App\Tests\Functional\PopularWord
 *
 * Test can class fetch GitHub for issues.
 */
class GitHubIssueFetcherTest extends WebTestCase

{
    /**
     * @covers GitHubIssueFetcher::fetch()
     */
    public function testFetchingResults()
    {
        self::bootKernel();

        $gitHubIssueFetcher = self::$container->get(GitHubIssueFetcher::class);

        $response = $gitHubIssueFetcher->fetch('foo');

        $this->assertInstanceOf(PopularWord::class, $response);
    }
}
