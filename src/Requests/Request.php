<?php

namespace Netatmo\Sdk\Requests;

use Netatmo\Sdk\Serialization;

interface Request
{
    /**
     * Return the path of the request
     *
     * @return string
     */
    public function getPath();

    /**
     * Return the HTTP method associated with the request
     *
     * @return string
     */
    public function getMethod();

    /**
     * Return the parameters associated with the request
     *
     * @return array
     */
    public function getParams();

    /**
     * Return whether the request will need an authorization header
     */
    public function withAuthorization();

    /**
     * Return the class that will be use to deserialize the response
     *
     * @return Serialization\ArrayDeserializer
     */
    public function getResponseDeserializer();
}
