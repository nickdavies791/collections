<?php

use Tests\TestCase;

class DNATest extends TestCase
{
    /**
     * @test
     */
    public function get_hamming_distance_between_two_strands_of_dna()
    {
        $strandA = 'ACCGGCCTCCGCAAGGCGCG';
        $strandB = 'GCGGTGCACAAGCAATTGAC';

        $distance = $this->hamming_distance($strandA, $strandB);

        $this->assertEquals(14, $distance);
    }

    /**
     * Returns the hamming distance between two DNA strands.
     *
     * @param $strandA
     * @param $strandB
     * @return int
     */
    private function hamming_distance($strandA, $strandB)
    {
        return collect(str_split($strandA))->zip(str_split($strandB))
            ->map(function ($pair) {
                list($a, $b) = $pair;
                return $a === $b ? 0 : 1;
            })->sum();
    }
}