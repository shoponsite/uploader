<?php

namespace Shoponsite\Uploader;

interface UploaderInterface {

    public function __construct(Config\Config $config);

    /**
     * @return bool
     */
    public function upload($uploadKey);

    /**
     * @return bool
     */
    public function multiUpload($uploadKey);

}