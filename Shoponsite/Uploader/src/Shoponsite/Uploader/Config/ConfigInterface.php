<?php

namespace Shoponsite\Uploader\Config;


interface ConfigInterface {

    /**
     * @param array|string $types
     * @example $config->setMimes(array('img/png', 'img/jpg'));
     * @example $config->setMimes('img/png');
     * @return self
     */
    public function setMimes($types);

    /**
     * Returns the array of valid mimetypes
     * @return array
     */
    public function getMimes();

    /**
     * Flushes all set mimetypes
     * @return self
     */
    public function flushMimes();



    /**
     * @param array|string $extensions
     * @example $config->setExtensions(array('png', 'jpg'))
     * @example $config->setExtensions('png')
     * @return self
     */
    public function setExtensions($extensions);

    /**
     * Returns an array of supported extensions
     * @return array
     */
    public function getExtensions();

    /**
     * Flushes all set extensions
     * @return self
     */
    public function flushExtensions();


    /**
     * Set the maximum filesize
     * @example $config->setMaximumSize('4M')
     * @return self
     */
    public function setMaximumSize($filesize);

    /**
     * Returns the set maximum filesize
     * @return string
     */
    public function getMaximumSize();
}