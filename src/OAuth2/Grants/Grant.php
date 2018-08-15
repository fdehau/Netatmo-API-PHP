<?php

namespace Netatmo\OAuth2\Grants;

use Netatmo\Encoding;

interface Grant extends Encoding\ArraySerializable
{
    public function getType();
}
