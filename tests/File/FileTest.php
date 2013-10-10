<?php

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

class FileTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $original = getcwd() . '/tests/Assets/original_sample.txt';
        $this->path = getcwd() . '/tests/Assets/sample.txt';
        copy($original, $this->path);
    }

    public function tearDown()
    {
        if(is_file($this->path))
            unlink($this->path);
        if(is_dir(getcwd() . '/tests/Assets/falsedir/'))
            rmdir(getcwd() . '/tests/Assets/falsedir/');
    }

    public function testLoadingFileObject()
    {
        $file = new File($this->path);
        $this->assertTrue($file->isFile());
    }

    public function testMovingFile()
    {
        $file = new File($this->path);
        mkdir(getcwd() . '/tests/Assets/subdir');
        $file = $file->move(new Filesystem(), getcwd() . '/tests/Assets/subdir');
        $this->assertSame(getcwd() . '/tests/Assets/subdir', $file->getPath());
        unlink($file->getPathname());
        rmdir(getcwd() . '/tests/Assets/subdir');
    }

    public function testMovingFileIntoNonExistingDirectory()
    {
        $file = new File($this->path);
        $file = $file->move(new Filesystem(), getcwd() . '/tests/Assets/falsedir');

        $this->assertSame(getcwd() . '/tests/Assets/falsedir', $file->getPath());
        $this->assertSame(getcwd() . '/tests/Assets/falsedir/sample.txt', $file->getPathname());

        unlink($file->getPathname());
    }

}
