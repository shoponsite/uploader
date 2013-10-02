<?php

namespace Shoponsite\Uploader;

use Shoponsite\Uploader\Storage\Filesystem;
use Shoponsite\Uploader\Validation\Validator;
use Shoponsite\Uploader\File\File;

class Uploader implements UploaderInterface{

    /**
     * @var Config\Config
     */
    protected $config;

    /**
     * @param Config\Config $config
     */
    public function __construct(Config\Config $config)
    {
        $this->config = $config;
    }


    /**
     * @return Upload
     */
    public function upload($uploadKey, $index = null)
    {
        $file = $this->generateFile($uploadKey, $index);

        $validator = new Validator($this->config, $file);

        if(!$validator->validate())
        {
            $this->cleanUp($file);

            return $validator->errors();
        }
        else
        {
            $this->handle($file, $this->getOriginalName($uploadKey));
        }
    }

    /**
     * @return MultiUpload
     */
    public function multiUpload($uploadKey)
    {
        $errors = array();

        foreach($_FILES['name'] as $index => $name)
        {
            $errors[$index] = $this->upload($uploadKey, $index);
        }

        return $errors;
    }

    /**
     * Cleanup the file to no longer be a tmp filename.
     *
     * This will allow validation of extension used, because the tmp name does not have an extension
     *
     * @param $uploadKey
     * @param $index
     * @return File
     */
    protected function generateFile($uploadKey, $index = null)
    {
        if(!$index)
        {
            $tmp = new File($_FILES[$uploadKey]['tmp_name']);
            return $tmp->move($tmp->getPath() . '/' . $_FILES[$uploadKey]['name']);
        }
        else
        {
            $tmp = new File($_FILES[$uploadKey]['tmp_name'][$index]);
            return $tmp->move($tmp->getPath() . '/' . $_FILES[$uploadKey]['name'][$index]);
        }

    }

    protected function handle(File $file, $name)
    {

        $storage = new Filesystem($this->config->getUploadPath());

        $parser = $this->config->getFilenameParser();

        if($parser && $parser instanceof Closure)
        {
            $name = $parser($name);
        }

        $storage->handle($file, $name);
    }

    protected function getOriginalName($uploadKey)
    {
        return $_FILES[$uploadKey]['name'];
    }

    protected function cleanUp($file)
    {
        unlink($file->getPathname());
    }

}