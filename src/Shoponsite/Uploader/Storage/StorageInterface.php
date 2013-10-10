<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

interface StorageInterface {

    /**
     * @param Filesystem $system
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct(Filesystem $filesystem, $directory);

    /**
     * @param File $file
     * @param $output
     * @return mixed
     */
    public function handle(File $file, $filename);

}