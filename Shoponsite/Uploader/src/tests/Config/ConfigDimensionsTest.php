<?php

use Shoponsite\Uploader\Config\Config;

class ConfigDimensionsTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->config = new Config();
    }

    public function tearDown()
    {
        unset($this->config);
    }


    /**
     * @expectedException Shoponsite\Uploader\Exceptions\InvalidDimensionException
     */
    public function testSettingInvalidDimensionsThrowsException()
    {
        $this->config->setDimensions(array(
            'some invalid key' => 400
        ));
    }

    public function testSettingProperDimensions()
    {
        $this->config->setDimensions(array(
            'minHeight' => 400,
            'minWidth' => 400
        ));
        $this->assertSame(array(
            'minHeight' => 400,
            'minWidth' => 400
        ), $this->config->getDimensions(), 'failed setting dimensions with correct footprint');
    }


}
