<?php

namespace App\Tests\Unit\PopularWord\Model;

use PHPUnit\Framework\TestCase;
use App\PopularWord\Model\SearchTerm;

/**
 * Class SearchTermTest
 *
 * @package App\Tests\Unit\PopularWord\Model
 *
 * Test that model can return data given in constructor.
 */
class SearchTermTest extends TestCase
{
    /**
     * @dataProvider termAndCountProvider
     * @covers       SearchTerm::getTerm()
     *
     * @param string $term
     * @param int    $occurrences
     */
    public function testGettingTerm(string $term, int $occurrences)
    {
        $this->assertEquals($term, (new SearchTerm($term, $occurrences))->getTerm());
    }

    /**
     * @dataProvider termAndCountProvider
     * @covers       SearchTerm::getOccurrences()
     *
     * @param string $term
     * @param int    $occurrences
     */
    public function testGettingScore(string $term, int $occurrences)
    {
        $this->assertEquals($occurrences, (new SearchTerm($term, $occurrences))->getOccurrences());
    }

    /**
     * Return term and count to test.
     *
     * @return array
     */
    public function termAndCountProvider(): array
    {
        return [
            ['php', 22423],
            ['js', 11111],
            ['c#', 1],
            ['python', 0],
            ['foo', 324234234234234234],
            ['bar', 23],
        ];
    }
}
