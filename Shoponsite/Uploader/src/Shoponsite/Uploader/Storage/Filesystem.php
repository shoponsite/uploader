<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Uploader\File\File;

class Filesystem implements StorageInterface{

    /**
     * @var File
     */
    protected $directory;

    /**
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct($directory)
    {
        $this->directory = new File($directory);
    }

    /**
     * @param File $file
     * @param string $filename  The filename that will be used when putting the file in the $this->directory
     * @return mixed
     */
    public function handle(File $file, $filename)
    {
    }


}