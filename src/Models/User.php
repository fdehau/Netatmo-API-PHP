<?php

namespace Netatmo\Sdk\Models;

use Netatmo\Sdk\Exceptions;

class User
{
    protected $email;
    protected $administrative;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAdministrative()
    {
        return $this->administrative;
    }

    public function setAdministrative($administrative)
    {
        $this->administrative = $administrative;
    }
}
