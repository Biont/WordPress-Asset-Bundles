<?php
declare(strict_types=1);

namespace Biont\AssetBundles;

class AssetBundle implements Enqueueable
{

    private $handle;
    /**
     * @var Asset[]
     */
    private $assets;

    /**
     * AssetBundle constructor.
     *
     * @param         $handle
     * @param Asset[] $assets
     */
    public function __construct($handle, array $assets)
    {

        $this->handle = $handle;
        $this->assets = $assets;
    }

    /**
     * Enqueues all assets
     */
    public function provide()
    {

        foreach ($this->assets as $asset) {
            $asset->enqueue();
        }
    }

    public function register(): bool
    {

        foreach ($this->assets as $asset) {
            $asset->register();
        }

        return true;
    }

    public function enqueue(): bool
    {

        foreach ($this->assets as $asset) {
            $asset->enqueue();
        }

        return true;
    }

    public function isEnqueued(): bool
    {

        foreach ($this->assets as $asset) {
            if (! $asset->isEnqueued()) {
                return false;
            }
        }

        return true;
    }

    public function isRegistered(): bool
    {

        foreach ($this->assets as $asset) {
            if (! $asset->isRegistered()) {
                return false;
            }
        }

        return true;
    }

}
