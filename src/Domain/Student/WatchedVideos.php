<?php

namespace Sophia\Calisthenics\Domain\Student;

use Sophia\Calisthenics\Domain\Video\Video;
use DateTimeInterface;
use Ds\Map;

class WatchedVideos implements \Countable
{
    private Map $videos;

    public function __construct()
    {
        $this->videos = new Map();
    }

    public function add(Video $video, DateTimeInterface $date): void
    {
        $this->videos->put($video, $date);
    }

    public function count(): int
    {
        return $this->videos->count();
    }

    public function dateOfFirstVideo(): DateTimeInterface
    {
        $this->videos->sort(fn (DateTimeInterface $dateA, DateTimeInterface $dateB) => 
        $dateA <=> $dateB);
        return $this->videos->first()->value;
    }
}
