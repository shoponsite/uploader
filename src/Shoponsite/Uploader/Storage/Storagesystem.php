<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Filesystem\File;
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
     * @param Filesystem $system
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct(Filesystem $system, $directory)
    {
        $this->filesystem = $system;
        $this->directory = new File($directory);
        $this->verifyDirectory();
    }

    /**
     * We also chmod the file here to a sane default.
     * We do not need group rights to be able to access the files through ftp.
     * The images and upload folder shouldn't really be used in that manner.
     *
     * @param File $file
     * @param string $filename  The filename that will be used when putting the file in the $this->directory
     * @return File
     */
    public function handle(File $file, $filename)
    {
        $file = $this->filesystem->move($file, $this->directory->getPathname());

        $this->filesystem->chmod($file, 0666 & ~umask());

        return $this->filesystem->rename($file, $filename);
    }

    /**
     * Check to see if directory already exists
     * Create it if necessary.
     * @return bool
     */
    protected function verifyDirectory()
    {
        if(!$this->directory->isDir())
        {
            return $this->makeDirectory(new File($this->directory->getPath()), $this->directory->getFilename());
        }

        return true;
    }

    /**
     * @param File $dir
     * @param $directoryName
     */
    protected function makeDirectory(File $dir, $directoryName)
    {
        if(!$dir->isDir())
        {
            $this->makeDirectory(new File($dir->getPath()), $dir->getFilename());
        }

        return mkdir($dir->getPathname() . '/' . $directoryName);
    }

}