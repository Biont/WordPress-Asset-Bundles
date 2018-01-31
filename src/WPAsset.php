<?php
declare(strict_types=1);

namespace Biont\AssetBundles;

abstract class WPAsset extends Asset
{

    /**
     * @var string;
     */
    private $src;

    /**
     * @var array
     */
    private $deps;
    /**
     * @var AssetUriGenerator
     */
    private $uriGen;

    public function __construct(
        $handle,
        $path,
        $deps = [],
        AssetUriGenerator $uriGen = null
    ) {

        parent::__construct($handle, $path);
        $this->deps = $deps;

        $this->uriGen = $uriGen ?? new AssetUriGenerator($path);
    }

    public function getSrc()
    {

        if (null === $this->src) {
            $this->src = $this->uriGen->getUri();

        }

        return $this->src;

    }

    public function getDeps(): array
    {

        return $this->deps;
    }

    /**
     * @return string|bool
     */
    public function getVersion(): string
    {

        return (string)filemtime($this->path);
    }
}
