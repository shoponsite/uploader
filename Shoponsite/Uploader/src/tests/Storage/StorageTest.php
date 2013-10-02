<?php

use Shoponsite\Uploader\Storage\Filesystem;

/**
 * Permissions denied are very hard to test,
 * since phpunit needs enough rights to access all the tests that need to be run.
 * Therefor we keep the original UnexpectedValueException that is being thrown,
 * when using our File class with not enough permissions on the path being used.
 */

class StorageTest extends PHPUnit_Framework_TestCase {

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
}
