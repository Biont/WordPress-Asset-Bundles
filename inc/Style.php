<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 17.11.16
 * Time: 20:44
 */

namespace Biont\AssetBundles;

class Style extends WPAsset {

	private $media;

	public function __construct(
		$handle,
		$path,
		$deps = [],
		$media = 'all',
		AssetUriGenerator $uriGen = null

	) {

		$this->media = $media;
		parent::__construct( $handle, $path, $deps, $uriGen );
	}

	final public function enqueue(): bool {

		if ( $this->isEnqueued() ) {
			return true;
		}

		if ( ! $this->isRegistered() ) {
			$this->register();
		}

		wp_enqueue_style(
			$this->getHandle()
		);

		return true;
	}

	/**
	 * @return bool
	 */
	public function isEnqueued(): bool {

		return wp_style_is( $this->getHandle() );
	}

	/**
	 * @return bool
	 */
	public function isRegistered(): bool {

		return wp_style_is( $this->getHandle(), 'registered' );
	}

	final public function register(): bool {

		if ( $this->isRegistered() ) {
			return true;
		}

		return wp_register_style(
			$this->getHandle(),
			$this->getSrc(),
			$this->getDeps(),
			$this->getVersion(),
			$this->media
		);
	}
}
