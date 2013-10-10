<?php

namespace Shoponsite\Uploader\Validation;

use Shoponsite\Uploader\Config\Config;
use Shoponsite\Filesystem\File;

interface ValidatorInterface {


    /**
     * @param Config $config
     * @param File $file
     */
    public function __construct(Config $config, File $file);

    /**
     * Validate the uploaded file against the current configuration.
     * @return bool
     */
    public function validate();

    /**
     * Return the errors for the validated file
     * @return array
     */
    public function errors();

}