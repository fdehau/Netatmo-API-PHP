<?php

namespace Netatmo\Requests;

interface Request
{
    public function getPath();

    public function getMethod();

    public function getParams();

    public function withAuthorization();

    public function getResponseClass();

    public function getResponseOptions();
}
