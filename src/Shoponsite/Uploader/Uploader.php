<?php

namespace Shoponsite\Uploader;

use Shoponsite\Uploader\Storage\Filesystem;
use Shoponsite\Uploader\Validation\Validator;
use Shoponsite\Uploader\File\File;
use Closure;

class Uploader implements UploaderInterface{

    /**
     * @var Config\Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $files = array();

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
            $this->handle($file, $this->getOriginalName($uploadKey, $index));
        }
    }

    /**
     * @return MultiUpload
     */
    public function multiUpload($uploadKey)
    {
        $errors = array();

        foreach($_FILES[$uploadKey]['name'] as $index => $name)
        {
            $fileErrors = $this->upload($uploadKey, $index);
            if(!empty($fileErrors))
            {
                $errors[$this->getOriginalName($uploadKey, $index)] = $fileErrors;
            }
        }

        return $errors;
    }

    public function files()
    {
        return $this->files;
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
        if($index === null)
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

        $file = $storage->handle($file, $name);

        array_push($this->files, $file);
    }

    protected function getOriginalName($uploadKey, $index = null)
    {
        if($index === null){
            return $_FILES[$uploadKey]['name'];
        }
        else
        {
            return $_FILES[$uploadKey]['name'][$index];
        }
    }

    protected function cleanUp($file)
    {
        unlink($file->getPathname());
    }

}