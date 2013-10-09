<?php

use Shoponsite\Uploader\Storage\Filesystem;
use Shoponsite\Uploader\File\File;

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
        copy(getcwd() . '/src/tests/Assets/picture.jpg', getcwd() . '/src/tests/Assets/copy.jpg');
        $this->file = new File(getcwd() . '/src/tests/Assets/copy.jpg');
    }

    public function tearDown()
    {
        unset($this->file);
        if(is_file(getcwd() . '/src/tests/Assets/storage/amazing_picture.jpg'))
            unlink(getcwd() . '/src/tests/Assets/storage/amazing_picture.jpg');
    }

    public function testDirCreationForNonExistingDirectory()
    {
        $path = getcwd() . '/src/tests/Assets/some/none/existing/dir';
        $system = new Filesystem($path);
        $this->assertTrue(is_dir($path));
        rmdir(getcwd() . '/src/tests/Assets/some/none/existing/dir');
        rmdir(getcwd() . '/src/tests/Assets/some/none/existing');
        rmdir(getcwd() . '/src/tests/Assets/some/none');
        rmdir(getcwd() . '/src/tests/Assets/some/');
    }

    public function testHandlingAnUpload()
    {
        $storage = new Filesystem(getcwd() . '/src/tests/Assets/storage');
        $storage->handle($this->file, 'amazing_picture.jpg');
        $this->assertTrue(is_file(getcwd() . '/src/tests/Assets/storage/amazing_picture.jpg'));
    }

}
