<?php

namespace Netatmo\Http;

use GuzzleHttp\Psr7\Stream;

class Body
{
    public static function fromString($string)
    {
        $stream = fopen('php://temp', 'r+');
        if ($string !== '') {
            fwrite($stream, $string);
            fseek($stream, 0);
        }
        return new Stream($stream);
    }

    public static function withJson(array $array)
    {
        return static::fromString(json_encode($array));
    }

    public static function withFormParams(array $array)
    {
        return static::fromString(http_build_query($array, null, "&"));
    }
}
