<?php

namespace Netatmo\Sdk\Requests;

class WindMeasures extends Measures
{
    public function getParams()
    {
        $this->types = [
            "WindStrength",
            "WindAngle",
            "GustStrength",
            "GustAngle",
            "date_max_gust";
        ];
        parent::getParams();
    }
}
