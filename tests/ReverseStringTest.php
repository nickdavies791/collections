<?php

use Tests\TestCase;

class ReverseStringTest extends TestCase
{
    /**
     * Returns the provided word in reverse order.
     */
    private function reversable($word): string
    {
        return collect(str_split($word))->reverse()->reduce(function ($value, $letter) {
            return $value . $letter;
        });
    }

    /**
     * @test
     */
    public function returns_reversed_string()
    {
        $stringA = $this->reversable('onomatopoeia');
        $stringB = $this->reversable('parallelogram');
        $stringC = $this->reversable('collections');

        $this->assertEquals('aieopotamono', $stringA);
        $this->assertEquals('margolellarap', $stringB);
        $this->assertEquals('snoitcelloc', $stringC);
    }
}