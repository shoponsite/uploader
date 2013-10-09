<?php

use Shoponsite\Uploader\Config\Config;

class ConfigUploadpathTest extends PHPUnit_Framework_TestCase {

    public function testSetFilepath()
    {
        $config = new Config();
        $path = getcwd() . '/src/tests/Assets/uploaddir';
        $config->setUploadPath($path);
        $this->assertInstanceOf('Shoponsite\Uploader\File\File', $config->getUploadPath());
        $file = $config->getUploadPath();
        $this->assertSame($path, $file->getPathname());
    }

}
