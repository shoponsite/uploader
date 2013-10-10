<?php

namespace Shoponsite\Uploader;

use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Uploader\Storage\Grabber;
use Shoponsite\Uploader\Config\Config;

interface UploaderInterface {

    /**
     * @param Config $config
     * @param Filesystem $filesystem
     * @param Grabber $grabber
     */
    public function __construct(Config $config, Filesystem $filesystem, Grabber $grabber);

    /**
     * @return bool
     */
    public function upload($uploadKey);

    /**
     * @return bool
     */
    public function multiUpload($uploadKey);

}