<?php

use Shoponsite\Uploader\Storage\Storagesystem;
use Shoponsite\Uploader\File\File;
use Shoponsite\Filesystem\Filesystem;

/**
 * Permissions denied are very hard to test,
 * since phpunit needs enough rights to access all the tests that need to be run.
 * Therefor we keep the original UnexpectedValueException that is being thrown,
 * when using our File class with not enough permissions on the path being used.
 */

class StorageTest extends PHPUnit_Framework_TestCase {

    /**
     * @var File
     */
    protected $file;


    public function setUp()
    {
        copy(getcwd() . '/tests/Assets/picture.jpg', getcwd() . '/tests/Assets/copy.jpg');
        $this->file = new File(getcwd() . '/tests/Assets/copy.jpg');
    }

    public function tearDown()
    {
        unset($this->file);
        if(is_file(getcwd() . '/tests/Assets/storage/amazing_picture.jpg'))
            unlink(getcwd() . '/tests/Assets/storage/amazing_picture.jpg');
    }

    public function testDirCreationForNonExistingDirectory()
    {
        $path = getcwd() . '/tests/Assets/some/none/existing/dir';
        $system = new Storagesystem($path, new Filesystem);
        $this->assertTrue(is_dir($path));
        rmdir(getcwd() . '/tests/Assets/some/none/existing/dir');
        rmdir(getcwd() . '/tests/Assets/some/none/existing');
        rmdir(getcwd() . '/tests/Assets/some/none');
        rmdir(getcwd() . '/tests/Assets/some/');
    }

    public function testHandlingAnUpload()
    {
        $storage = new Storagesystem(getcwd() . '/tests/Assets/storage', new Filesystem);
        $storage->handle($this->file, 'amazing_picture.jpg');
        $this->assertTrue(is_file(getcwd() . '/tests/Assets/storage/amazing_picture.jpg'));
    }

}
