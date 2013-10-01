<?php

namespace Shoponsite\Uploader\Validation;


use Shoponsite\Uploader\Config\Config;
use Shoponsite\Uploader\File\File;

class Validator implements ValidatorInterface{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var File
     */
    protected $file;

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


}