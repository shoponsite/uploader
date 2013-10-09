<?php

use Shoponsite\Uploader\Config\Config;

class ConfigExtensionTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->config = new Config();
    }

    public function tearDown()
    {
        unset($this->config);
    }

    public function testSettingExtensionsByArray()
    {
        $this->config->setExtensions(array('png', 'jpg'));
        $this->assertSame(array('png', 'jpg'), $this->config->getExtensions(), 'failed setting extensions by array.');
    }

    public function testSettingExtensionsByString()
    {
        $this->config->setExtensions('png');
        $this->config->setExtensions('jpg');
        $this->assertSame(array('png', 'jpg'), $this->config->getExtensions(), 'failed setting extensions by string.');
    }

    public function testFlushingExceptions()
    {
        $this->config->setExtensions(array('png', 'jpg'));
        $this->config->flushExtensions();
        $this->assertSame(array(), $this->config->getExtensions(), 'failed flushing extensions');
    }

    public function testSettingDuplicateWillNotBeAdded()
    {
        $this->config->setExtensions(array('png', 'jpg'));
        $this->config->setExtensions('png');
        $this->assertSame(array('png', 'jpg'), $this->config->getExtensions());
    }

}
