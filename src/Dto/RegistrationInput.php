<?php

declare(strict_types=1);


namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationInput
{
    public function __construct(private readonly string $username, private readonly string $email, private readonly string $password, private readonly string $number)
    {
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(5)
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(9)
     */
    public function getNumber(): string
    {
        return $this->number;
    }

}