<?php

namespace Sophia\Calisthenics\Tests\Unit\Domain\Student;

use Sophia\Calisthenics\Domain\Student\Student;
use Sophia\Calisthenics\Domain\Student\FullName;
use Sophia\Calisthenics\Domain\Email\Email;
use Sophia\Calisthenics\Domain\Video\Video;
use PhpUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    private Student $student;

    protected function setUp(): void
    {
        $this->student = new Student(
            new Email('email@example.com'),
            new \DateTimeImmutable('2007-05-11'),
            new FullName('Sophia','Lacerda'),
            'Rua de Exemplo',
            '2',
            'Meu Bairro',
            'Minha Cidade',
            'Meu Estado',
            'Brasil'
        );
    }

    public function testFullNameMustBeRepresentedAsString()
    {
        self::assertEquals('Sophia Lacerda', $this->student->fullName());
    }

    public function testStudentWithoutWatchedVideoHasAcess()
    {
        self::assertTrue($this->student->hasAcess());
    }

    public function testStudentWithFirstWatchedVideoInLessThan90DaysHasAcess()
    {
        $date = new \DateTimeImmutable('89 days');
        $this->student->watch(new Video(), $date);

        self::assertTrue($this->student->hasAcess());
    }

    public function testStudentWithFirstWatchedVideoInLessThanMtGrandeMds()
    {
        $this->student->watch(new Video(), new \DateTimeImmutable('-89 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-60 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-30 days'));

        self::assertTrue($this->student->hasAcess());
    }

    public function testDoesntAcess()
    {
        $date = new \DateTimeImmutable('-90 days');
        $this->student->watch(new Video(), $date);

        self::assertFalse($this->student->hasAcess());
    }

    public function testStudentWithFirstWatchedVideoInLessThanMtGrandeSemAcesso()
    {
        $this->student->watch(new Video(), new \DateTimeImmutable('-90 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-100 days'));
        $this->student->watch(new Video(), new \DateTimeImmutable('-302 days'));

        self::assertFalse($this->student->hasAcess());
    }
}
