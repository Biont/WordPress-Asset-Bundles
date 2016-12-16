<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 03.12.16
 * Time: 01:31
 */

namespace Biont\AssetBundles;


abstract class WPAsset extends Asset {


	/**
	 * @var string;
	 */
	private $src;

	/**
	 * @var array
	 */
	private $deps;

	public function __construct( $handle, $path, $deps = [] ) {
		parent::__construct( $handle, $path );
		$this->deps = $deps;

	}

	/**
	 * Produce a URL to this asset file.
	 *
	 * It will assume that any asset is located somewhere below the wp-content folder (which may be called differently)
	 * Based on that, it will traverse the file's directpories upwards until the WP_CONTENT_DIR base name is found.
	 *
	 * Then the found fragments are appended to the content_url()
	 *
	 * @return string
	 */
	public function get_src() {

		if ( is_null( $this->src ) ) {

			$root_dir   = wp_normalize_path( dirname( $this->path ) );
			$parts      = explode( DIRECTORY_SEPARATOR, $root_dir );
			$wp_content = basename( WP_CONTENT_DIR );
			while ( array_shift( $parts ) !== $wp_content ) {
				//We don't actually need to do anything here
			}
			$root_url  = content_url( '/' . implode( '/', $parts ) );
			$this->src = trailingslashit( $root_url ) . basename( $this->path );
		}

		return $this->src;

	}

	/**
	 * @return array
	 */
	public function get_deps() {
		return $this->deps;
	}

	/**
	 * @return string|bool
	 */
	public function get_version() {
		return filemtime( $this->path );
	}
}