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
        $this->verifyDirectory();
    }

    /**
     * @param File $file
     * @param string $filename  The filename that will be used when putting the file in the $this->directory
     * @return mixed
     */
    public function handle(File $file, $filename)
    {
        $file->move($this->directory->getPathname() . '/' . $filename);
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