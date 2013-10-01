<?php

namespace Shoponsite\Uploader\Config;

use Shoponsite\Uploader\Exceptions\InvalidMimeTypeException;


class Config implements ConfigInterface{

    /**
     * @var array
     */
    protected $mimes = array();

    /**
     * @var array
     */
    protected $extensions = array();
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

    /**
     * @param array|string $extensions
     * @example $config->setExtensions(array('png', 'jpg'))
     * @example $config->setExtensions('png')
     * @return self
     */
    public function setExtensions($extensions)
    {
        if(is_string($extensions))
        {
            $extensions = array($extensions);
        }

        if(is_array($extensions))
        {
            $this->extensions = array_unique(array_merge($this->extensions, $extensions));
        }

        return $this;

    }

    /**
     * Returns an array of supported extensions
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Flushes all set extensions
     * @return self
     */
    public function flushExtensions()
    {
        $this->extensions = array();

        return $this;
    }
}