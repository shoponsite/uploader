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
    public function upload($uploadKey)
    {
        $file = $this->generateFile($uploadKey);

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
        // TODO: Implement multiUploader() method.
    }

    protected function generateFile($uploadKey)
    {
        return new File($_FILES[$uploadKey]['tmp_name']);
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