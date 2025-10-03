<?php

namespace Sophia\Calisthenics\Domain\Student;

use Sophia\Calisthenics\Domain\Adress\Adress;
use Sophia\Calisthenics\Domain\Email\Email;
use Sophia\Calisthenics\Domain\Student\FullName;
use Sophia\Calisthenics\Domain\Video\Video;
use DateTimeInterface;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDate;
    private WatchedVideos $watchedVideos;
    private FullName $fullName;
    private Adress $adress;

    public function __construct(
        Email $email,
        DateTimeInterface $birthDate,
        FullName $fullName,
        Adress $adress
    ) {
        $this->watchedVideos = new WatchedVideos();
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->fullName = $fullName;
        $this->adress = $adress;
    }

    public function fullName(): string
    {
        return "{$this->fullName}";
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->add($video, $date);
    }

    public function hasAcess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;
        }

        $firstDate = $this->watchedVideos->dateOfFirstVideo();
        $today = new \DateTimeImmutable();

        return $firstDate->diff($today)->days < 90;
    }

    public function age(): int
    {
        $today = new \DateTimeImmutable();
        $dateInterval = $this->birthDate->diff($today);

        return $dateInterval->y;
    }
}
