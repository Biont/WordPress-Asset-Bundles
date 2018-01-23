<?php # -*- coding: utf-8 -*-
declare( strict_types=1 );

namespace Biont\AssetBundles;

class AssetUriGenerator {

	/**
	 * @var string
	 */
	private $path;

	public function __construct( string $path ) {


		$this->path = $path;
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
	public function getUri(): string {

		$root_dir   = \wp_normalize_path( \dirname( $this->path ) );
		$parts      = explode( DIRECTORY_SEPARATOR, $root_dir );
		$wp_content = basename( WP_CONTENT_DIR );
		while ( array_shift( $parts ) !== $wp_content ) {
			//We don't actually need to do anything here
		}
		$root_url = \content_url( '/' . implode( '/', $parts ) );

		return \trailingslashit( $root_url ) . basename( $this->path );
	}
}
