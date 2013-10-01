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

    public function testExtensionsPassWhenNoExtensionsSpecified()
    {
        $validator = new Validator($this->config, $this->file);
        $this->assertTrue($validator->validate(), 'test failed when not setting extensions');
    }

    public function testInvalidExtension()
    {
        $this->config->setExtensions('png','jpg');
        $validator = new Validator($this->config, $this->file);
        $message = 'test failed when file has invalid extension';
        $this->assertFalse($validator->validate(), $message);
        $this->assertCount(1, $validator->errors(), $message);
        $this->assertContains(Validator::INVALID_EXTENSION, $validator->errors(), $message);
    }

    public function testValidExtension()
    {
        $this->config->setExtensions(array('txt'));
        $validator = new Validator($this->config, $this->file);
        $this->assertTrue($validator->validate());
    }

    public function testMultipleErrors()
    {
        $this->config->setMimes(array('img/png'))
           ->setExtensions(array('png'));
        $validator = new Validator($this->config, $this->file);
        $message = 'test failed for multiple errors.';
        $this->assertFalse($validator->validate(), $message);
        $this->assertCount(2, $validator->errors(), $message);
        $this->assertContains(Validator::INVALID_MIME, $validator->errors(), $message);
        $this->assertContains(Validator::INVALID_MIME, $validator->errors(), $message);
    }

    public function testInvalidFilesize()
    {
        $this->config->setMaximumSize('1B');
        $validator = new Validator($this->config, $this->file);
        $message = 'test failed for invalid filesize';
        $this->assertFalse($validator->validate(), $message);
        $this->assertCount(1, $validator->errors(), $message);
        $this->assertContains(Validator::INVALID_FILE_SIZE, $validator->errors(), $message);
    }

    public function testValidFilesize()
    {
        $this->config->setMaximumSize('1M');
        $validator = new Validator($this->config, $this->file);
        $this->assertTrue($validator->validate());
    }

}
