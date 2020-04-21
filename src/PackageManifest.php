<?php

namespace HttpClient\Plugin;

class PackageManifest
{
    /**
     * The vendor path.
     *
     * @var string
     */
    protected $vendorPath;

    /**
     * The manifest path.
     *
     * @var string
     */
    protected $manifestPath;

    /**
     * Create a new package manifest instance.
     *
     * @param string $vendorPath
     */
    public function __construct($vendorPath)
    {
        $this->vendorPath = $vendorPath;
        $this->manifestPath = $this->vendorPath.'/http-client/plugin/manifest.php';
    }

    /**
     * Remove manifest file.
     *
     * @return $this
     */
    public function unlink()
    {
        if (file_exists($this->manifestPath)) {
            @unlink($this->manifestPath);
        }

        return $this;
    }

    /**
     * Build the manifest file.
     *
     * @return  void
     */
    public function build()
    {
        $packages = [];

        if (file_exists($installed = $this->vendorPath.'/composer/installed.json')) {
            $packages = json_decode(file_get_contents($installed), true);
        }

        $manifest = [];

        foreach ($packages as $package) {
            $manifest[$package['name']] = $package['extra']['http-client'] ?? [];
        }

        $this->write(array_filter($manifest));
    }

    /**
     * Write the manifest array to a file.
     *
     * @param array $manifest
     *
     * @return  void
     */
    protected function write(array $manifest)
    {
        file_put_contents(
            $this->manifestPath,
            '<?php return '.var_export($manifest, true).';'
        );
    }
}
