<?php

namespace App\Tests\Functional\Controller;

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
     * @uses PopularWordFetcherInterface::fetch()
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
}
