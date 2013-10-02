<?php

use Shoponsite\Uploader\File\File;

class FileTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $original = getcwd() . '/src/tests/Assets/original_sample.txt';
        $this->path = getcwd() . '/src/tests/Assets/sample.txt';
        copy($original, $this->path);
    }

    public function tearDown()
    {
        unlink($this->path);
        if(is_dir(getcwd() . '/src/tests/Assets/falsedir/'))
            rmdir(getcwd() . '/src/tests/Assets/falsedir/');
    }

    public function testLoadingFileObject()
    {
        $file = new File($this->path);
        $this->assertTrue($file->isFile());
    }

    public function testMovingFile()
    {
        $file = new File($this->path);
        $this->path = getcwd() . '/src/tests/Assets/tmp_copy.txt';
        $newfile = $file->move($this->path);
        $tmp = new File($this->path);
        $this->assertTrue($tmp->isFile());
        $this->assertSame($this->path, $newfile->getPathname());
    }

    public function testMovingFileIntoNonExistingDirectory()
    {
        $file = new File($this->path);
        $this->path = getcwd() . '/src/tests/Assets/falsedir/tmp.txt';
        $newfile = $file->move($this->path);
        $tmp = new File($this->path);
        $this->assertTrue($tmp->isFile());
        $this->assertSame($this->path, $newfile->getPathname());
    }

}
