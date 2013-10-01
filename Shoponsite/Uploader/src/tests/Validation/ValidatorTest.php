<?php

use Shoponsite\Uploader\Config\Config;
use Shoponsite\Uploader\File\File;

class ValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var string
     */
    protected $path;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var Config
     */
    protected $config;

    public function setUp()
    {
        $this->path = getcwd() . '/src/tests/Assets/original_sample.txt';
        $this->file = new File($this->path);
        $this->config = new Config();
    }

    public function tearDown()
    {
        unset($this->path);
        unset($this->file);
        unset($this->config);
    }


}
