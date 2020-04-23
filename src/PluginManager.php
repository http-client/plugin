<?php

namespace HttpClient\Plugin;

class PluginManager
{
    protected $manifestPath;
    protected $manifest;

    public function __construct()
    {
        $this->manifestPath = __DIR__.'/../manifest.php';
    }

    public function definitions()
    {
        return $this->config('definitions');
    }

    public function extensions()
    {
        return $this->config('extensions');
    }

    protected function config($key)
    {
        $configuration = [];

        foreach ($this->getManifest() as $package => $value) {
            $configuration = array_merge($configuration, $value[$key] ?? []);
        }

        return $configuration;
    }

    /**
     * Get the package manifest.
     *
     * @return arrray
     */
    protected function getManifest()
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        return $this->manifest = file_exists($this->manifestPath) ? require $this->manifestPath : [];
    }
}
