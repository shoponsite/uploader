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

    public function testSettingNoCallbackGivesADefaultParser()
    {
        $method = $this->config->getFilenameParser();
        $this->assertInstanceOf('Closure', $method);
        $this->assertSame('test', $method('test'));
    }

    public function testSettingCallbackBecomesWrappedInDefaultParser()
    {
        $this->config->setFilenameParser(function($name)
        {
            echo $name;
        });
        $method = $this->config->getFilenameParser();
        $this->assertInstanceOf('Closure', $method);
        $this->expectOutputString('test', $method('test'));
    }

}
