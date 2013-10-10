<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Uploader\File\File;
use Shoponsite\Filesystem\Filesystem;

interface StorageInterface {

    /**
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct($directory, Filesystem $filesystem);

    /**
     * @param File $file
     * @param $output
     * @return mixed
     */
    public function handle(File $file, $filename);

}