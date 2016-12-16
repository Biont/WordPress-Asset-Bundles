<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 17.11.16
 * Time: 20:42
 */

namespace Biont\AssetBundles;


abstract class Asset {
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
	 * @throws \Exception
	 */
	public function __construct( $handle, $path ){
		if ( ! file_exists( $path ) ) {
			throw new \Exception( "Asset file not found: {$path}" );
		}
		$this->handle = $handle;
		$this->path   = $path;
	}

	/**
	 * @return string
	 */
	public function get_handle() {
		return $this->handle;
	}



	abstract public function register();

	/**
	 * @return bool
	 */
	abstract public function is_registered();

	abstract public function enqueue();

	/**
	 * @return bool
	 */
	abstract public function is_enqueued();
}