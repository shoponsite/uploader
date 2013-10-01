<?php

use Shoponsite\Uploader\Validation\Validator;
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

    public function testMimes()
    {
        $this->config->setMimes(array('text/plain'));
        $validator = new Validator($this->config, $this->file);
        $this->assertTrue($validator->validate(), 'test failed for valid mime type');
    }

    public function testInvalidMimes()
    {
        $this->config->setMimes(array('img/png'));
        $validator = new Validator($this->config, $this->file);
        $message = 'test failed when mime is invalid';
        $this->assertFalse($validator->validate(), $message);
        $this->assertCount(1, $validator->errors(), $message);
        $this->assertContains(Validator::INVALID_MIME, $validator->errors(), $message);
    }

    public function testMimesPassWhenNoMimesSpecified()
    {
        $validator = new Validator($this->config, $this->file);
        $this->assertTrue($validator->validate(), 'test failed when not setting mimes in config');
    }


}
