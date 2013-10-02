<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Uploader\File\File;

interface StorageInterface {

    /**
     * @param File $directory    The destination directory that should be used.
     */
    public function __construct($directory);

    /**
     * @param File $file
     * @param $output
     * @return mixed
     */
    public function handle(File $file, $filename);

}