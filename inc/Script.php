<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 17.11.16
 * Time: 20:43
 */

namespace Biont\AssetBundles;


class Script extends WPAsset {
	/**
	 * @var array
	 */
	private $localization;
	/**
	 * @var
	 */
	private $in_footer;

	public function __construct( $handle, $path, $deps = [], $in_footer = true, $localization = [] ) {
		parent::__construct( $handle, $path, $deps );
		$this->localization = $localization;
		$this->in_footer    = $in_footer;
	}

	public final function register() {
		if ( $this->is_registered() ) {
			return;
		}

		wp_register_script(
			$this->get_handle(),
			$this->get_src(),
			$this->get_deps(),
			$this->get_version(),
			$this->in_footer
		);
	}

	public final function enqueue() {
		if ( $this->is_enqueued() ) {
			return;
		}

		if ( ! $this->is_registered() ) {
			$this->register();
		}
		wp_enqueue_script(
			$this->get_handle()
		);
		$this->localize();
	}

	public function localize() {
		foreach ( $this->localization as $object_name => $object ) {
			wp_localize_script( $this->get_handle(), $object_name, $object );
		}
	}

	public function is_registered() {
		return wp_script_is( $this->get_handle(), 'registered' );
	}

	public function is_enqueued() {
		return wp_script_is( $this->get_handle() );
	}
}