<?php

namespace Shoponsite\Uploader\File;

use SplFileInfo;

class File extends SplFileInfo implements FileInterface{

    public function __construct($path)
    {
        parent::__construct($path);
    }

    /**
     * @param string $path
     * @return self
     */
    public function move($path)
    {
        $path = new SplFileInfo($path);
        $dir = new SplFileInfo($path->getPath());
        if(!$dir->isDir())
        {
            mkdir($dir->getPath() . '/' . $dir->getFilename());
        }
        rename($this->getPath() . '/' . $this->getFilename(), $path);

        return new self($path);
    }


}