<?php

namespace Sophia\Calisthenics\Domain\Email;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException();
        }

        $this->email = $email;
    }

    public function __tostring(): string
    {
        return $this->email;
    }
}
