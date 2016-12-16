<?php
/**
 * Created by PhpStorm.
 * User: biont
 * Date: 03.12.16
 * Time: 00:38
 */

namespace Biont\AssetBundles;


use Biont\WPCore\EJSTemplateLoader;

class TemplateCollection extends Asset {
	/**
	 * @var EJSTemplateLoader
	 */
	private $loader;
	/**
	 * @var bool
	 */
	private $enqueued = false;

	public function __construct( $handle, $path ) {
		parent::__construct( $handle, $path );

		$this->loader = new EJSTemplateLoader( $this->path );
	}

	public function register() {
		return;
	}

	/**
	 * @return bool
	 */
	public function is_registered() {
		return true;
	}

	public function enqueue() {
		if ( $this->is_enqueued() ) {
			return;
		}
		$hook = ( is_admin() ) ? 'admin_footer' : 'wp_footer';
		add_action( $hook, function () {
			$this->loader->print_templates();
		} );
		$this->enqueued = true;
	}

	/**
	 * @return bool
	 */
	public function is_enqueued() {
		return $this->enqueued;
	}
}