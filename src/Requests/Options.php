<?php

namespace Netatmo\Sdk\Requests;

class Options
{
    const DECODE_BODY = "decode_body";

    /**
     * Whether the body of the response should be decoded and converted
     * to the corresponding PHP class. Set it to false to have the result
     * returned as a PHP array
     */
    protected $decodeBody = true;

    public function shouldDecodeBody()
    {
        return $this->decodeBody;
    }

    public function setDecodeBody($flag)
    {
        $this->decodeBody = $flag;
    }

    public static function fromArray(array $array)
    {
        $options = new self();
        if (isset($array[self::DECODE_BODY])) {
            $options->setDecodeBody($array[self::DECODE_BODY]);
        }
        return $options;
    }
}
