<?php

use Shoponsite\Uploader\Config\Config;

class ConfigUploadpathTest extends PHPUnit_Framework_TestCase {

    public function testSetFilepath()
    {
        $config = new Config();
        $path = getcwd() . '/tests/Assets/uploaddir';
        $config->setUploadPath($path);
        $this->assertInstanceOf('Shoponsite\Filesystem\File', $config->getUploadPath());
        $file = $config->getUploadPath();
        $this->assertSame($path, $file->getPathname());
    }

}
