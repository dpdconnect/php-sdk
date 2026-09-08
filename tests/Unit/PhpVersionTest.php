<?php

namespace DpdConnect\Sdk\Test\Unit;

use PHPUnit\Framework\TestCase;

class PhpVersionTest extends TestCase
{
    private function preparePhpVersion()
    {
        list($major, $minor, $patch) = explode('.', PHP_VERSION);
        return $major * 10000 + $minor * 100 + $patch;
    }

    public function testIfBuildPhpVersionIsEqual()
    {
        $comparisonVersion = $this->preparePhpVersion();

        $client = new \DpdConnect\Sdk\Common\HttpClient('');
        $buildPhpVersion = $client->buildPhpVersion();
        $this->assertEquals($comparisonVersion, $buildPhpVersion);
    }

    public function testIfMetricPhpVersionIsEqual()
    {
        $comparisonVersion = $this->preparePhpVersion();
        $expectedMetricVersionFormat = 'PHP/' . $comparisonVersion;

        $client = new \DpdConnect\Sdk\Common\HttpClient('');
        $phpVersion = $client->getPhpVersion();

        $this->assertEquals($expectedMetricVersionFormat, $phpVersion);
    }
}