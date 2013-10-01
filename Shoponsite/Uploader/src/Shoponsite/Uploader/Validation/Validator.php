<?php

namespace Shoponsite\Uploader\Validation;


use Shoponsite\Uploader\Config\Config;
use Shoponsite\Uploader\File\File;
use finfo;

class Validator implements ValidatorInterface{

    const INVALID_MIME = 'MIME_ERROR';
    const INVALID_EXTENSION = 'EXTENSION_ERROR';
    const INVALID_FILE_SIZE = 'INVALID_FILE_SIZE';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var finfo
     */
    protected $mimehelper;

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @param Config $config
     * @param File $file
     */
    public function __construct(Config $config, File $file){
        $this->config = $config;
        $this->file = $file;
        $this->mimehelper = new finfo(FILEINFO_MIME_TYPE);
    }

    /**
     * Validate the uploaded file against the current configuration.
     * @param Config $config
     * @param File $file
     * @return bool
     */
    public function validate()
    {
        $this->validateMimes();
        $this->validateExtensions();
        $this->validateFilesize();
//        $this->validateDimensions();
        return empty($this->errors);
    }

    /**
     * Return the errors for the validated file
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Validate mime types, should pass when no mimes were specified
     */
    protected function validateMimes()
    {
        $mimes = $this->config->getMimes();

        if($mimes)
        {
            $mime = $this->mimehelper->file($this->file->getPathname());

            if(!in_array($mime, $mimes))
            {
                array_push($this->errors, STATIC::INVALID_MIME);
            }
        }

    }

    protected function validateExtensions()
    {
        $extensions = $this->config->getExtensions();

        if($extensions)
        {
            $extension = $this->file->getExtension();

            if(!in_array($extension, $extensions))
            {
                array_push($this->errors, STATIC::INVALID_EXTENSION);
            }
        }
    }

    protected function validateFilesize()
    {
        $maxFileSize = $this->config->getMaximumSize();

        if($maxFileSize)
        {
            if($this->file->getSize() > $maxFileSize)
            {
                array_push($this->errors, STATIC::INVALID_FILE_SIZE);
            }
        }
    }


}