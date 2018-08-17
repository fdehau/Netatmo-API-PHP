<?php

namespace Netatmo\Sdk\Requests;

interface Request
{
    public function getPath();

    public function getMethod();

    public function getParams();

    public function withAuthorization();

    public function getResponseDeserializer();
}
