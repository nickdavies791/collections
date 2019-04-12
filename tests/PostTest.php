<?php

use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function get_total_count_of_comments_written_before_2019()
    {
        $posts = collect($this->load('posts.json'));

        $commentCount = $posts->filter(function ($comment) {
            return new DateTime($comment->created_at) < new DateTime('2019-01-01 00:00:00');
        })->count();

        return $this->assertEquals(3, $commentCount);
    }
}