<?php

namespace Netatmo\Responses;

class Measures extends Response
{
    protected $measures = [];

    public function pushMeasure($type, $ts, $value)
    {
        if (!isset($this->measures[$type]))
        {
            $this->measures[$type] = [];
        }
        $this->measures[$type][$ts] = $value;
    }

    public function get($type)
    {
        return isset($this->measures[$type])
            ? $this->measures[$type]
            : [];
    }

    public static function fromArray(array $array, array $options)
    {
        $res = new self();
        $optimized = isset($options["optimize"]) && $options["optimize"];
        $types = $options["types"];
        if ($optimized) {
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
                        if (!isset($types[$j])) {
                            continue;
                        }
                        $type = $types[$j];
                        $ts = $start + $i * $step;
                        $res->pushMeasure($type, $ts, $value);
                    }
                }
            }
        } else {
            foreach ($array as $ts => $values) {
                foreach ($values as $i => $value) {
                    if (!isset($types[$i])) {
                        continue;
                    }
                    $type = $types[$i];
                    $res->pushMeasure($type, $ts, $value);
                }
            }
        }
        return $res;
    }
}
