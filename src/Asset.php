<?php
declare(strict_types=1);

namespace Biont\AssetBundles;

abstract class Asset implements Enqueueable
{

    /**
     * @var string
     */
    protected $handle;

    /**
     * @var string
     */
    protected $path;

    /**
     * Asset constructor.
     *
     * @param $handle
     * @param $path
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($handle, $path)
    {

        if (! file_exists($path)) {
            throw new \InvalidArgumentException("Asset file not found: {$path}");
        }
        $this->handle = $handle;
        $this->path   = $path;
    }

    public function getHandle(): string
    {

        return $this->handle;
    }

    abstract public function register(): bool;

    abstract public function isRegistered(): bool;

    abstract public function enqueue(): bool;

    abstract public function isEnqueued(): bool;
}
