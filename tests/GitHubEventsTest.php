<?php

use Tests\TestCase;

class GitHubEventsTest extends TestCase
{
    /**
     * @test
     */
    public function get_list_of_all_event_types()
    {
        $events = collect($this->load('github-events.json'));

        $eventTypeList = $events->map(function ($event) {
            return $event->type;
        })->unique()->flatten()->all();

        return $this->assertEquals([
            'PushEvent',
            'PullRequestEvent',
            'CreateEvent'
        ], $eventTypeList);
    }

    /**
     * @test
     */
    public function get_users_github_score()
    {
        $events = collect($this->load('github-events.json'));

        $score = $events->pluck('type')->map(function ($type) {
            return $this->scoreTable()->get($type, 1);
        })->sum();

        $this->assertEquals(139, $score);
    }

    /**
     * The lookup table for types and scores.
     */
    private function scoreTable()
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2
        ]);
    }
}