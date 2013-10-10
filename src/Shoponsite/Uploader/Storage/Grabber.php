<?php

namespace Shoponsite\Uploader\Storage;

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

class Grabber implements GrabberInterface{

    /**
     * Cleanup the file to no longer be a tmp filename.
     *
     * This will allow validation of extension used, because the tmp name does not have an extension
     *
     * @param string $uploadKey
     * @param int|null $index
     * @return File
     */
    public function grab(Filesystem $system, $uploadKey, $index = null)
    {
        if($index === null)
        {
            $tmp = new File($_FILES[$uploadKey]['tmp_name']);
            return $tmp->move($system, $tmp->getPath() . '/' . $_FILES[$uploadKey]['name']);
        }
        else
        {
            $tmp = new File($_FILES[$uploadKey]['tmp_name'][$index]);
            return $tmp->move($system, $tmp->getPath() . '/' . $_FILES[$uploadKey]['name'][$index]);
        }

    }

    public function originalName($uploadKey, $index = null)
    {
        if($index === null){
            return $_FILES[$uploadKey]['name'];
        }
        else
        {
            return $_FILES[$uploadKey]['name'][$index];
        }
    }

}