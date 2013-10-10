<?php

use Shoponsite\Uploader\Storage\Grabber;
use Shoponsite\Filesystem\Filesystem;

class GrabberTest extends PHPUnit_Framework_TestCase {

    /**
     * At the time of writing, i did not fully understand how this all works.
     *
     * This might be completely wrong or this might even be totally stupid.
     * Because we actually not run the method but fake it,
     * because we do not have access to the $_FILES array
     */
    public function testGrab()
    {
        $grabber = new Grabber();

        $grabber = $this->getMock('Shoponsite\Uploader\Storage\Grabber');

        $actualFile = new \Shoponsite\Filesystem\File(getcwd() . '/tests/Assets/picture.jpg');

        $grabber->expects($this->any())
            ->method('grab')
            ->with(new Filesystem, 'test', null)
            ->will($this->returnValue($actualFile));

        $this->assertSame($actualFile, $grabber->grab(new \Shoponsite\Filesystem\Filesystem(), 'test'));

    }

}
