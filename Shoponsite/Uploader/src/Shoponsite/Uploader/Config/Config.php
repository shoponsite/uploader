<?php

namespace Shoponsite\Uploader\Config;

use Shoponsite\Uploader\Exceptions\InvalidMimeTypeException;


class Config implements ConfigInterface{

    /**
     * @var array
     */
    protected $mimes = array();
    /**
     * @param array|string $types
     * @example $config->setMimes(array('img/png', 'img/jpg'));
     * @example $config->setMimes('img/png');
     * @return self
     */
    public function setMimes($types)
    {
        if(is_array($types))
        {
            $this->mimes = array_merge($this->mimes, $types);
        }
        else
        {
            $this->mimes = array_merge($this->mimes, array($types));
        }

        $this->mimes = array_unique($this->mimes);

        $this->validateMimes();

        return $this;
    }

    /**
     * Returns the array of valid mimetypes
     * @return array
     */
    public function getMimes()
    {
        return $this->mimes;
    }

    /**
     * Flushes all set mimetypes
     * @return self
     */
    public function flushMimes()
    {
        $this->mimes = array();

        return $this;
    }

    /**
     * Clean up mimetypes that are invalid
     */
    protected function validateMimes()
    {
        foreach($this->mimes as $key => $mime)
        {
            if(!preg_match('/^[a-z]+\/[a-z]+$/', $mime))
            {
                throw new InvalidMimeTypeException('You tried setting an invalid mime');
            }
        }
    }
}