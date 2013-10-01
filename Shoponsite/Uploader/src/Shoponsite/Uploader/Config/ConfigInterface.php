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


}