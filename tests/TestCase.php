<?php
namespace Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Returns json file as a collection.
     *
     * @param $file
     * @return \Illuminate\Support\Collection
     */
    public function load($file)
    {
        return json_decode(file_get_contents('./json/' . $file));
    }
}