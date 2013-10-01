<?php

use Shoponsite\Uploader\Config\Config;

class ConfigMimeTest extends PHPUnit_Framework_TestCase {

    protected $config;

    public function setUp()
    {
        $this->config = new Config();
    }

    public function tearDown()
    {
        unset($this->config);
    }

    public function testSetMimetypesByArray()
    {
        $this->config->setMimes(array('img/png','img/jpg'));
        $this->assertSame(array('img/png', 'img/jpg'), $this->config->getMimes(), 'failed setting mimes by array');
    }

    public function testSetMimetypesByString()
    {
        $this->config->setMimes('img/png');
        $this->config->setMimes('img/jpg');
        $this->assertSame(array('img/png', 'img/jpg'), $this->config->getMimes(), 'failed setting mimes by key');
    }

    public function testFlushMimetypes()
    {
        $this->config->setMimes(array('img/png', 'img/jgp'));
        $this->config->flushMimes();
        $this->assertSame(array(), $this->config->getMimes(), 'failed flushing mimes');
    }

    public function testSettingDuplicateMimes()
    {
        $this->config->setMimes('img/png');
        $this->config->setMimes('img/png');
        $this->assertSame(array('img/png'), $this->config->getMimes(), 'failed setting duplicate mime');
    }

    /**
     * @expectedException Shoponsite\Uploader\Exceptions\InvalidMimeTypeException
     */
    public function testErrorOnInvalidMime()
    {
        $this->config->setMimes('img/some invalid mime');
    }

}
