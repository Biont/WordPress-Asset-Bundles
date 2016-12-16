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

	public function __construct( $handle, $path, $deps = [], $media = 'all' ) {
		$this->media = $media;
		parent::__construct( $handle, $path, $deps );
	}

	public final function register() {
		if ( $this->is_registered() ) {
			return;
		}
		wp_register_style(
			$this->get_handle(),
			$this->get_src(),
			$this->get_deps(),
			$this->get_version(),
			$this->media
		);
	}

	public final function enqueue() {
		if ( $this->is_enqueued() ) {
			return;
		}

		if ( ! $this->is_registered() ) {
			$this->register();
		}

		wp_enqueue_style(
			$this->get_handle()
		);
	}


	/**
	 * @return bool
	 */
	public function is_registered() {
		return wp_style_is( $this->get_handle(), 'registered' );
	}

	/**
	 * @return bool
	 */
	public function is_enqueued() {
		return wp_style_is( $this->get_handle() );
	}
}