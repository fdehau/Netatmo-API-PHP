<?php

namespace Netatmo\Sdk\Serialization;

use Netatmo\Sdk\Exceptions;

abstract class ArraySerializer
{
    public function toArray($object)
    {
        if (!$this->canSerialize($object)) {
            $type = \gettype($object);
            if ($type === "object") {
                $type = \get_class($object);
            }
            throw new Exceptions\Error(
                "Cannot serialize object of type $type"
            );
        }
        return $this->__toArray($object);
    }

    abstract protected function __toArray($object);

    abstract protected function canSerialize($object);
}
