<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Uploader\File\File;
use Shoponsite\Filesystem\Filesystem;

class Storagesystem implements StorageInterface{

    /**
     * @var File
     */
    protected $directory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct($directory, Filesystem $system)
    {
        $this->directory = new File($directory);
        $this->verifyDirectory();
        $this->filesystem = $system;
    }

    /**
     * @param File $file
     * @param string $filename  The filename that will be used when putting the file in the $this->directory
     * @return File
     */
    public function handle(File $file, $filename)
    {
        $file = $this->filesystem->move($file, $this->directory->getPathname());

        return $this->filesystem->rename($file, $filename);
    }

    protected function verifyDirectory()
    {
        if(!$this->directory->isDir())
        {
            return $this->makeDirectory(new File($this->directory->getPath()), $this->directory->getFilename());
        }

        return true;
    }

    protected function makeDirectory(File $dir, $directoryName)
    {
        if(!$dir->isDir())
        {
            $this->makeDirectory(new File($dir->getPath()), $dir->getFilename());
        }
        mkdir($dir->getPathname() . '/' . $directoryName);
    }

}