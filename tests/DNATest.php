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
     * @test
     */
    public function get_reverse_sequence_of_strand_of_dna()
    {
        $strand = 'CCUGCAACUUAGGCAGG';

        $reverse = $this->reverse_sequence($strand);

        $this->assertEquals('GGACGGAUUCAACGUCC', $reverse);
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

    /**
     * Returns the reverse sequence for a given DNA strand.
     *
     * @param $strand
     * @return mixed
     */
    private function reverse_sequence($strand)
    {
        return collect(str_split($strand))->reverse()->reduce(function ($value, $letter) {
            return $value . $letter;
        });
    }
}