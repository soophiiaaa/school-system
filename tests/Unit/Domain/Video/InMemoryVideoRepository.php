<?php

namespace Sophia\Calisthenics\Tests\Unit\Domain\Video;

use Sophia\Calisthenics\Domain\Student\Student;
use Sophia\Calisthenics\Domain\Video\InMemoryVideoRepository;
use Sophia\Calisthenics\Domain\Video\Video;
use PHPUnit\Framework\TestCase;

class InMemoryVideoRepositoryTest extends TestCase
{
    public function testFindingVideosForAsStudentMustFilterAgeLimit()
    {
        $repository = new InMemoryVideoRepository();

        for ($i = 21; $i >= 17; $i--) {
            $video = new Video();
            $video->setAgeLimit($i);
            $repository->add($video);
        }

        $student = $this->createStub(Student::class);
        $student->method('getBd')->willReturn(19);

        $videoList = $repository->videosFor($student);

        self::assertCount(3, $videoList);
    }
}
