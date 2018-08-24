<?php

namespace Netatmo\Sdk\Tests;

use Netatmo\Sdk\Requests;
use Netatmo\Sdk\Http;
use Psr\Http\Message\RequestInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function assertRequest(array $expected, RequestInterface $request) {
        if (isset($expected["method"])) {
            $this->assertEquals(
                $expected["method"],
                $request->getMethod(),
                "Methods do not match"
            );
        }
        if (isset($expected["params"])) {
            switch ($request->getMethod()) {
                case Http\Method::POST:
                    $body = (string) $request->getBody();
                    $params = json_decode($body, true);
                    $this->assertEquals(
                        $expected["params"],
                        $params,
                        "Parameters do no match"
                    );
                    break;
                case Http\Method::GET:
                    $query = $request->getUri()->getQuery();
                    $params = [];
                    parse_str($query, $params);
                    $this->assertEquals(
                        $expected["params"],
                        $params,
                        "Parameters do no match"
                    );
                    break;
            }
        }
        if (isset($expected["headers"])) {
            foreach ($expected["headers"] as $key => $value) {
                $this->assertEquals(
                    $value,
                    $request->getHeaderLine($key),
                    "$key headers do not match"
                );
            }
        }
    }
}
