<?php

use Tests\TestCase;

class PalindromeTest extends TestCase
{
    private function isPalindrome($word): string
    {
        return collect(str_split($word));
    }

    /**
     * @test
     */
    public function a_given_word_is_a_palindrome()
    {
        dd($this->isPalindrome('hannah'));
    }
}