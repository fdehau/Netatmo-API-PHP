<?php

namespace Netatmo\Sdk\OAuth2\Grants;

interface Grant
{
    public function getType();

    public function getParams();
}
