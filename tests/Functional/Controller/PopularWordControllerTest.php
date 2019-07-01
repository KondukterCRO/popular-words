<?php

namespace App\Tests\Functional\Controller;

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
     */
    public function testGettingWordAndItsScore()
    {
        $client = static::createClient();

        $client->request('GET', '/score?term=php');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}
