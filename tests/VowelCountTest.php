<?php

use Tests\TestCase;
use Tightenco\Collect\Support\Collection;

class VowelCountTest extends TestCase
{
    /**
     * Returns the number of vowels in a given word.
     */
    private function countVowels($word): int
    {
        return collect(str_split($word))->map(function ($letter) {
            return $this->vowelTable()->get(strtoupper($letter), 0);
        })->sum();
    }

    /**
     * Returns a collection of vowels and scores.
     */
    private function vowelTable(): Collection
    {
        return collect([
            'A' => 1,
            'E' => 1,
            'I' => 1,
            'O' => 1,
            'U' => 1,
        ]);
    }

    /**
     * @test
     */
    public function returns_correct_number_of_vowels_in_given_string()
    {
        $stringA = $this->countVowels('Hello!'); // 2
        $stringB = $this->countVowels('A wonderfully long sentence with many vowels!'); // 12
        $stringC = $this->countVowels('Why?'); // 0

        $this->assertEquals(2, $stringA);
        $this->assertEquals(12, $stringB);
        $this->assertEquals(0, $stringC);
    }
}