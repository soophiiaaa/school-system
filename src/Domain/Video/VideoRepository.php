<?php

namespace Sophia\Calisthenics\Domain\Video;

use Sophia\Calisthenics\Domain\Student\Student;

interface VideoRepository
{
    public function add(Video $video): void;
    public function videosFor(Student $student): array;
}
