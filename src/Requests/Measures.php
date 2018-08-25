<?php

namespace Netatmo\Sdk\Requests;

use Netatmo\Sdk\Http;
use Netatmo\Sdk\Exceptions;
use Netatmo\Sdk\Serialization;
use Netatmo\Sdk\Parameters;

/**
 * Request to retrieve sensor(s) measure(s) from a device
 */
class Measures implements Request
{
    /**
     * Create a new request for measures of a device or one of its modules
     *
     * @param string $deviceId id of the device
     * @param string $moduleId id of the module
     * @param Parameters\Measures $measures options for the measures query
     *
     * @return Measures
     */
    protected function __construct(
        $deviceId,
        $moduleId,
        Parameters\Measures $measures
    ) {
        $this->deviceId = $deviceId;
        $this->moduleId = $moduleId;
        $this->measures = $measures;
    }

    /**
     * Start building a request for measures of a device
     *
     * @param string $deviceId id of a device
     *
     * @return Measures
     */
    public static function ofDevice(
        $deviceId,
        Parameters\Measures $measures
    ) {
        return new self($deviceId, null, $measures);
    }

    /**
     * Start building a request for measures of a module
     *
     * @param string $deviceId id of the main device to which the module is linked
     * @param string $moduleId id of the module
     *
     * @return Measures
     */
    public static function ofModule(
        Parameters\Module $module,
        Parameters\Measures $measures
    ) {
        return new self(
            $module->getDeviceId(),
            $module->getId(),
            $measures
        );
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return "api/getmeasure";
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return Http\Method::GET;
    }

    /**
     * @inheritDoc
     */
    public function getParams()
    {
        $params = [
            "device_id" => $this->deviceId,
            "scale" => $this->measures->getScale(),
            "type" => implode(",", $this->measures->getTypes()),
            "optimize" => $this->measures->isOptimized(),
            "real_time" => !$this->measures->shouldKeepOffset(),
        ];
        if ($this->moduleId !== null) {
            $params["module_id"] = $this->moduleId;
        }
        if ($this->measures->hasStart()) {
            $params["start"] = $this->measures->getStart();
        }
        if ($this->measures->hasEnd()) {
            $params["end"] = $this->measures->getEnd();
        }
        if ($this->measures->hasLimit()) {
            $params["limit"] = $this->measures->getLimit();
        }
        return $params;
    }

    /**
     * @inheritDoc
     */
    public function getResponseDeserializer()
    {
        return new Serialization\Responses\MeasuresDeserializer(
            $this->measures->isOptimized(),
            $this->measures->getTypes()
        );
    }

    /**
     * @inheritDoc
     */
    public function withAuthorization()
    {
        return true;
    }
}
