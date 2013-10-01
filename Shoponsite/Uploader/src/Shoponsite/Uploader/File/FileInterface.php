<?php

namespace Shoponsite\Uploader\File;


interface FileInterface {

    public function __construct($path);

    /**
     * @param string $path
     * @return self
     */
    public function move($path);

}