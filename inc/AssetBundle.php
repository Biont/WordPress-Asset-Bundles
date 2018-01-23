<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 18.11.16
 * Time: 22:16
 */

namespace Biont\AssetBundles;

class AssetBundle implements Registerable {

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
	public function __construct( $handle, array $assets ) {

		$this->handle = $handle;
		$this->assets = $assets;
	}

	/**
	 * Enqueues all assets
	 */
	public function provide() {

		foreach ( $this->assets as $asset ) {
			$asset->enqueue();
		}
	}

	public function register(): bool {

		foreach ( $this->assets as $asset ) {
			$asset->register();
		}

		return true;
	}
}
