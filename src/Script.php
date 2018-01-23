<?php
declare( strict_types=1 );

namespace Biont\AssetBundles;

class Script extends WPAsset {

	/**
	 * @var array
	 */
	private $localization;
	/**
	 * @var bool
	 */
	private $in_footer;

	public function __construct(
		string $handle,
		string $path,
		array $deps = [],
		bool $in_footer = true,
		array $localization = [],
		AssetUriGenerator $uriGen = null
	) {

		parent::__construct( $handle, $path, $deps, $uriGen );
		$this->localization = $localization;
		$this->in_footer    = $in_footer;
	}

	final public function enqueue(): bool {

		if ( $this->isEnqueued() ) {
			return true;
		}

		if ( ! $this->isRegistered() ) {
			$this->register();
		}
		\wp_enqueue_script(
			$this->getHandle()
		);

		return $this->localize();
	}

	public function isEnqueued(): bool {

		return (bool) wp_script_is( $this->getHandle() );
	}

	public function isRegistered(): bool {

		return (bool) wp_script_is( $this->getHandle(), 'registered' );
	}

	final public function register(): bool {

		if ( $this->isRegistered() ) {
			return true;
		}

		return (bool) wp_register_script(
			$this->getHandle(),
			$this->getSrc(),
			$this->getDeps(),
			$this->getVersion(),
			$this->in_footer
		);
	}

	public function localize(): bool {

		foreach ( $this->localization as $object_name => $object ) {
			$result = wp_localize_script( $this->getHandle(), $object_name, $object );
			if ( ! $result ) {
				return false;
			}
		}

		return true;
	}
}
