<?php

namespace Netatmo\Sdk\Exceptions;

class OAuth2Error extends \Exception
{
    protected $error;

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }
}
