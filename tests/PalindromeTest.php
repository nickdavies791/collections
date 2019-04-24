<?php

use Tests\TestCase;

class PalindromeTest extends TestCase
{
    /**
     * Returns whether given word is a palindrome.
     */
    private function isPalindrome($word): bool
    {
        $reversed = collect(str_split($word))->reverse()->reduce(function ($value, $letter) {
            return $value . $letter;
        });

        return $word === $reversed ? true : false;
    }

    /**
     * @test
     */
    public function a_given_word_is_a_palindrome()
    {
        $stringA = $this->isPalindrome('hannah');
        $stringB = $this->isPalindrome('octopus');

        $this->assertEquals(true, $stringA);
        $this->assertEquals(false, $stringB);
    }
}