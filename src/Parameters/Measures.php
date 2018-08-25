<?php

namespace Netatmo\Sdk\Parameters;

class Measures
{
    protected $types = [];
    protected $scale;
    protected $start;
    protected $end;
    protected $limit;
    protected $optimize = true;
    protected $keepOffset = true;

    public function __construct(array $types, $scale)
    {
        $this->types = $types;
        $this->scale = $scale;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getScale()
    {
        return $this->scale;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function isOptimized()
    {
        return $this->optimize;
    }

    public function shouldKeepOffset()
    {
        return $this->keepOffset;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Disable the bandwidth optimization
     *
     * If disabled the measures will be returned with a timestamp for each
     * measure point. This is nicer to parse on the receiving end but it
     * results in larger payloads.
     *
     * If not disabled, the measures will be returned in batches.
     *
     * If you are using the php response class of this request, this is taken
     * care of internally. Thus you should leave the optimization on.
     *
     */
    public function disableOptimization()
    {
        $this->optimize = false;
    }

    public function disableOffset()
    {
        $this->keepOffset = false;
    }

    public function hasStart()
    {
        return $this->start !== null;
    }

    public function hasEnd()
    {
        return $this->end !== null;
    }

    public function hasLimit()
    {
        return $this->limit !== null;
    }
}
