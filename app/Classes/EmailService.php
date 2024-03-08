<?php

namespace App\Classes;

use Exception;

class EmailService
{
    private $email;

    /**
     * @throws Exception
     */
    private function __construct(string $email)
    {
        $this->_ensureIsValidEmail($email);
        $this->email = $email;
    }
    public static function fromString(string $email): self
    {
        return new self($email);
    }
    public function __toString(): string
    {
        return $this->email;
    }
    private function _ensureIsValidEmail(string $email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception(sprintf('"%s" is not a valid email addresss', $email)
         );
      }
    }
}