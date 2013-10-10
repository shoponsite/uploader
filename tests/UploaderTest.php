<?php

use Shoponsite\Uploader\Config\Config;
use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Uploader\Uploader;
use Shoponsite\Filesystem\File;

class UploaderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function setUp()
    {
        $this->config = new Config();
        $this->config->setMaximumSize('10M')
            ->setExtensions(array('jpg', 'gif', 'png', 'jpeg'))
            ->setMimes(array('image/jpeg', 'image/png', 'image/gif'))
            ->setUploadPath(getcwd() . '/tests/Assets/storage')
            ->setFilenameParser(function($name)
            {
                return $name;
            })
            ->setDimensions(array(
                'minWidth' => 400,
                'minHeight' => 400
            ));
        $this->filesystem = new Filesystem();
    }

    public function tearDown()
    {
        unset($this->config);
        unset($this->filesystem);
    }

    public function testValidSingleUpload()
    {
        copy(getcwd() . '/tests/Assets/picture.jpg', getcwd() . '/tests/Assets/somerandomtempname.jpg');
        $file = new \Shoponsite\Filesystem\File(getcwd() . '/tests/Assets/somerandomtempname.jpg');

        $grabber = $this->getMock('Shoponsite\Uploader\Storage\Grabber');

        $grabber->expects($this->once())
            ->method('grab')
            ->with($this->filesystem, 'test', null)
            ->will($this->returnValue($file));

        $grabber->expects($this->any())
            ->method('originalName')
            ->with('test', null)
            ->will($this->returnValue('copy.jpg'));

        $uploader = new Uploader($this->config, $this->filesystem, $grabber);
        $uploader->upload('test', null);


        $actualFile = new File(getcwd() . '/tests/Assets/storage/copy.jpg');

        $files = $uploader->files();

        //file added to array
        $this->assertCount(1, $files);
        //ensure we have a file object in that array
        $this->assertInstanceOf('Shoponsite\Filesystem\File', $files[0]);
        //ensure the file is the same, can't use object matcher
        $this->assertSame($files[0]->getPathname(), $actualFile->getPathname());
        //original removed
        $this->assertFalse($file->isFile());
        unlink(getcwd() . '/tests/Assets/storage/copy.jpg');
    }

    public function testInvalidSingleUpload()
    {

    }

}
