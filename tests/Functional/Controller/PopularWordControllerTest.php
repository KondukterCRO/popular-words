<?php

namespace App\Tests\Functional\Controller;

use App\Controller\PopularWordController;
use App\PopularWord\GitHubIssueFetcher;
use App\PopularWord\WordPopularityGenerator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\PopularWord\PopularWordFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PopularWordControllerTest
 *
 * @package App\Tests\Functional\Controller
 *
 * Base test that will execute API call and check results.
 */
class PopularWordControllerTest extends WebTestCase
{
    /**
     * @covers PopularWordController::getScore()
     * @uses   PopularWordFetcherInterface::fetch()
     */
    public function testGettingWordAndItsScoreWithValidParams()
    {
        $client = static::createClient();

        $client->request('GET', '/score?term=php');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $response = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('term', $response);
        $this->assertObjectHasAttribute('score', $response);
    }

    /**
     * @covers PopularWordController::getScore()
     */
    public function testGettingWordAndItsScoreWithoutTermParam()
    {
        $client = static::createClient();

        $client->request('GET', '/score');

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $response = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('errors', $response);
        $this->assertObjectHasAttribute('field', $response->errors);
        $this->assertObjectHasAttribute('status', $response->errors);
        $this->assertEquals('term', $response->errors->field);
        $this->assertEquals('missing', $response->errors->status);
    }

    /**
     * @covers PopularWordController::getScore()
     * @uses   PopularWordFetcherInterface::fetch()
     */
    public function testGettingWordAndItsScoreWithParamWithNoDbRecordsAndGitHubUnavailable()
    {
        $popularWordFetcher = $this->getMockBuilder(GitHubIssueFetcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wordPopularityGenerator = new WordPopularityGenerator(
            $popularWordFetcher,
            $entityManager
        );

        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($entityRepository));

        $entityRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $entityManager
            ->expects($this->never())
            ->method('persist');

        $entityManager
            ->expects($this->never())
            ->method('flush');

        $popularWordFetcher
            ->expects($this->once())
            ->method('fetch')
            ->will($this->throwException(new \RuntimeException()));

        $request = Request::createFromGlobals();
        $request->query->set('term', 'foo');

        $jsonResponse = (new PopularWordController())->getScore($wordPopularityGenerator, $request);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $jsonResponse->getStatusCode());
        $this->assertJson($jsonResponse->getContent());
        $response = json_decode($jsonResponse->getContent());
        $this->assertObjectHasAttribute('errors', $response);
        $this->assertObjectHasAttribute('content', $response->errors);
        $this->assertEquals('not found', $response->errors->content);
    }
}
