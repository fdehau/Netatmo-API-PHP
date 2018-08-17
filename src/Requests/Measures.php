<?php

namespace Netatmo\Requests;

use Netatmo\Api;
use Netatmo\Http;
use Netatmo\Exceptions;
use Netatmo\Serialization;

/**
 * ```php
 *  $request = Measures::ofDevice($deviceId)
 *      ->withTypes(['Temperature'])
 *      ->every('5min')
 *      ->from(3600)
 *      ->to(3600)
 *      ->limit(512)
 *      ->optimize()
 *      ->withoutTimeOffset();
 * ```
 */
class Measures implements Request
{
    public function __construct($deviceId, $moduleId = null)
    {
        $this->deviceId = $deviceId;
        $this->moduleId = $moduleId;
        $this->start = null;
        $this->end = null;
        $this->scale = null;
        $this->limit = null;
        $this->optimize = true;
        $this->withTimeOffset = null;
    }

    public static function ofModule($deviceId, $moduleId)
    {
        return new self($deviceId, $moduleId);
    }

    public static function ofDevice($deviceId)
    {
        return new self($deviceId);
    }

    public function withTypes(array $types)
    {
        $this->types = $types;
        return $this;
    }

    public function from($start)
    {
        $this->start = $start;
        return $this;
    }

    public function to($end)
    {
        $this->end = $end;
        return $this;
    }

    public function every($scale)
    {
        $this->scale = $scale;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function withoutOptimization()
    {
        $this->optimize = false;
        return $this;
    }

    public function withoutTimeOffset()
    {
        $this->withTimeOffset = false;
        return $this;
    }

    public function getPath()
    {
        return Api::URI . "/getmeasure";
    }

    public function getMethod()
    {
        return Http\Method::GET;
    }

    public function getParams()
    {
        if ($this->scale === null) {
            throw new Exceptions\Error(
                "missing scale on Measures request, look at the documentation"
                . " of Measures::every for more explanations"
            );
        }
        if (empty($this->types)) {
            throw new Exceptions\Error(
                "missing types on Measures request, look at the documentation"
                . "of Measures::withTypes for more explanations"
            );
        }
        $params = [
            "device_id" => $this->deviceId,
            "scale" => $this->scale,
            "type" => join(",", $this->types)
        ];
        if ($this->moduleId !== null) {
            $params["module_id"] = $this->moduleId;
        }
        if ($this->start !== null) {
            $params["start"] = $this->start;
        }
        if ($this->end !== null) {
            $params["end"] = $this->end;
        }
        if ($this->optimize !== null) {
            $params["optimize"] = $this->optimize;
        }
        if ($this->withTimeOffset !== null) {
            $params["real_time"] = $this->withTimeOffset;
        }
        return $params;
    }

    public function getResponseDeserializer()
    {
        return new Serialization\Responses\MeasuresDeserializer(
            $this->optimize,
            $this->types
        );
    }

    public function withAuthorization()
    {
        return true;
    }
}
