<?php

use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function get_total_number_of_comments_written_before_2019()
    {
        $posts = collect($this->load('posts.json'));

        $commentCount = $posts->filter(function ($comment) {
            return new DateTime($comment->created_at) < new DateTime('2019-01-01 00:00:00');
        })->count();

        return $this->assertEquals(3, $commentCount);
    }

    /**
     * @test
     */
    public function get_word_count_for_each_post_in_order_of_most_to_least()
    {
        $posts = collect($this->load('posts.json'));

        $postWithWordCount = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'words' => strlen($post->body)
            ];
        })->sortByDesc('words')->values()->all();

        $this->assertEquals([
            ['title' => 'My fourth post', 'words' => 45],
            ['title' => 'My second post', 'words' => 43],
            ['title' => 'My first post', 'words' => 39],
            ['title' => 'My third post', 'words' => 35]
        ], $postWithWordCount);
    }
}