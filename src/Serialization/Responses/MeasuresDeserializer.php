<?php

namespace Netatmo\Serialization\Responses;

use Netatmo\Responses;
use Netatmo\Serialization;

class MeasuresDeserializer implements Serialization\ArrayDeserializer
{
    protected $optimize;

    protected $types = [];

    public function __construct($optimize, array $types)
    {
        $this->optimize = $optimize;
        $this->types = $types;
    }

    public function fromArray(array $array)
    {
        $res = new Responses\Measures();
        if ($this->optimize) {
            foreach ($array as $batch) {
                if (!isset($batch["beg_time"]) ||
                    !isset($batch["step_time"]) ||
                    !isset($batch["value"])) {
                    continue;
                }
                $start = $batch["beg_time"];
                $step = $batch["step_time"];
                foreach ($batch["value"] as $i => $values) {
                    foreach ($values as $j => $value) {
                        if (!isset($this->types[$j])) {
                            continue;
                        }
                        $type = $this->types[$j];
                        $ts = $start + $i * $step;
                        $res->pushMeasure($type, $ts, $value);
                    }
                }
            }
        } else {
            foreach ($array as $ts => $values) {
                foreach ($values as $i => $value) {
                    if (!isset($this->types[$i])) {
                        continue;
                    }
                    $type = $this->types[$i];
                    $res->pushMeasure($type, $ts, $value);
                }
            }
        }
        return $res;
    }
}
