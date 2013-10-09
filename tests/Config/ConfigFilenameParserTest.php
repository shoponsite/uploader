<?php

use Shoponsite\Uploader\Config\Config;

class ConfigFilenameParserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Config
     */
    protected $config;

    public function setUp()
    {
        $this->config = new Config();
    }

    public function tearDown()
    {
        unset($this->config);
    }

    public function testSettingCallback()
    {
        $this->config->setFilenameParser(function()
        {
            echo 'test';
        });
        $method = $this->config->getFilenameParser();
        $this->assertInstanceOf('Closure', $method);
        $this->expectOutputString('test', $method());
    }

}
