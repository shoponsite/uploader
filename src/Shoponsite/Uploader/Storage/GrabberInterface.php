<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Uploader\File\File;
use Shoponsite\Filesystem\Filesystem;

interface GrabberInterface {

    /**
     * Cleanup the file to no longer be a tmp filename.
     *
     * This will allow validation of extension used, because the tmp name does not have an extension
     *
     * @param Filesystem $system
     * @param string $uploadKey
     * @param int|null $index
     * @return File
     */
    public function grab(Filesystem $system, $uploadKey, $index = null);

    public function originalName($uploadKey, $index = null);

}