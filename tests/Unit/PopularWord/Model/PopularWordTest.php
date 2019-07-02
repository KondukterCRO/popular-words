<?php

namespace App\Tests\Unit\PopularWord\Model;

use PHPUnit\Framework\TestCase;
use App\PopularWord\Model\PopularWord;

/**
 * Class PopularWordTest
 *
 * @package App\Tests\Unit\PopularWord\Model
 *
 * Test that model can return data given in constructor.
 */
class PopularWordTest extends TestCase
{
    /**
     * @dataProvider termAndScoreProvider
     * @covers       PopularWord::getTerm()
     *
     * @param string $term
     * @param float  $score
     */
    public function testGettingTerm(string $term, float $score)
    {
        $this->assertEquals($term, (new PopularWord($term, $score))->getTerm());
    }

    /**
     * @dataProvider termAndScoreProvider
     * @covers       PopularWord::getScore()
     *
     * @param string $term
     * @param float  $score
     */
    public function testGettingScore(string $term, float $score)
    {
        $this->assertEquals($score, (new PopularWord($term, $score))->getScore());
    }

    /**
     * Return term and score to test.
     *
     * @return array
     */
    public function termAndScoreProvider(): array
    {
        return [
            ['php', 10.00],
            ['js', 0.12],
            ['c#', 1.5],
            ['python', 2],
            ['foo', 0],
            ['bar', 5.4],
        ];
    }
}
