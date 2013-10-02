<?php
use Shoponsite\Uploader\Config\Config;

class ConfigFilesizeTest extends PHPUnit_Framework_TestCase {

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

    public function testSettingMaxFilesize()
    {
        $this->config->setMaximumSize('4M');
        $this->assertSame(4 * 1024 * 1024, $this->config->getMaximumSize());
        $this->config->setMaximumSize('6G');
        $this->assertSame(6 * 1024 * 1024 * 1024, $this->config->getMaximumSize());
        $this->config->setMaximumSize('4K');
        $this->assertSame(4 * 1024, $this->config->getMaximumSize());
        $this->config->setMaximumSize('4B');
        $this->assertSame(4, $this->config->getMaximumSize());
    }

}
