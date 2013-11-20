<?php

namespace Shoponsite\Uploader;

use Shoponsite\Uploader\Storage\Storagesystem;
use Shoponsite\Uploader\Validation\Validator;
use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Uploader\Storage\Grabber;
use Shoponsite\Uploader\Config\Config;
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
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Grabber
     */
    protected $grabber;

    /**
     * @param Config $config
     * @param Filesystem $filesystem
     * @param Grabber $grabber
     */
    public function __construct(Config $config, Filesystem $filesystem, Grabber $grabber)
    {
        $this->config = $config;

        $this->filesystem = $filesystem;

        $this->grabber = $grabber;
    }

    /**
     * @return Upload
     */
    public function upload($uploadKey, $index = null)
    {
        $file = $this->grabber->grab($this->filesystem, $uploadKey, $index);

        $validator = new Validator($this->config, $file);

        if(!$validator->validate())
        {
            $this->cleanUp($file);

            return $validator->errors();
        }
        else
        {
            $this->handle($file, $this->grabber->originalName($uploadKey, $index), $index);
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
                $errors[$this->grabber->originalName($uploadKey, $index)] = $fileErrors;
            }
        }

        return $errors;
    }

    public function files()
    {
        return $this->files;
    }

    protected function handle(File $file, $name, $index = null)
    {

        $storage = new Storagesystem($this->filesystem, $this->config->getUploadPath());

        $parser = $this->config->getFilenameParser();

        if($parser && $parser instanceof Closure)
        {
            if($index !== null)
            {
                $name = $parser($name, $index + 1);
            }
            else
            {
                $name = $parser($name);
            }
        }

        $file = $storage->handle($file, $name);

        array_push($this->files, $file);
    }

    protected function cleanUp($file)
    {
        unlink($file->getPathname());
    }

}