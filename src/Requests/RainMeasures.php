<?php

namespace Netatmo\Sdk\Requests;

class RainMeasures extends Measures
{
    public function getParams()
    {
        $this->types = ($this->scale === "max") ? ["Rain"] : "sum_rain";
        parent::getParams();
    }
}
