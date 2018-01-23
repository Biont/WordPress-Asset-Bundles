<?php # -*- coding: utf-8 -*-
declare( strict_types=1 );

use Biont\AssetBundles\AssetUriGenerator;
use Biont\AssetBundles\Style;
use Biont\AssetBundles\Test\Helper\DummyDataProvider;
use Brain\Monkey\Functions;
use MonkeryTestCase\BrainMonkeyWpTestCase;

class StyleTest extends BrainMonkeyWpTestCase {

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $styleHandle
	 * @param string $path
	 */
	public function test_register(
		string $styleHandle,
		string $path,
		array $dependencies,
		bool $media
	) {

		$alreadyRegistered = (bool) random_int( 0, 1 );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		Functions\expect( 'wp_style_is' )->andReturn( $alreadyRegistered );
		Functions\expect( 'wp_register_style' )->andReturn( true );
		$style  = new Style( $styleHandle, $path, $dependencies, $media, $uriGen );
		$result = $style->register();
		$this->assertSame( true, $result );
	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $styleHandle
	 * @param string $path
	 */
	public function test_enqueue(
		string $styleHandle,
		string $path,
		array $dependencies,
		bool $media
	) {

		$alreadyEnqueued   = (bool) random_int( 0, 1 );
		$alreadyRegistered = (bool) random_int( 0, 1 );

		Functions\expect( 'wp_style_is' )
			->with( $styleHandle )
			->andReturn( $alreadyEnqueued );

		Functions\expect( 'wp_style_is' )
			->with( $styleHandle, 'registered' )
			->andReturn( $alreadyRegistered );

		if ( ! $alreadyRegistered ) {
			Functions\expect( 'wp_register_style' )->andReturn( true );
		}

		if ( ! $alreadyEnqueued ) {
			Functions\expect( 'wp_enqueue_style' )->andReturn( true );
		}

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$style  = new Style( $styleHandle, $path, $dependencies, $media, $uriGen );
		$result = $style->enqueue();
		$this->assertSame( true, $result );

	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $styleHandle
	 * @param string $path
	 */
	public function test_isEnqueued(
		string $styleHandle,
		string $path,
		array $dependencies,
		bool $media
	) {

		$alreadyEnqueued = (bool) random_int( 0, 1 );
		Functions\expect( 'wp_style_is' )
			->with( $styleHandle )
			->andReturn( $alreadyEnqueued );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$style  = new Style( $styleHandle, $path, $dependencies, $media, $uriGen );
		$result = $style->isEnqueued();
		$this->assertSame( $alreadyEnqueued, $result );

	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $styleHandle
	 * @param string $path
	 */
	public function test_isRegistered(
		string $styleHandle,
		string $path,
		array $dependencies,
		bool $media
	) {


		$alreadyRegistered = (bool) random_int( 0, 1 );
		Functions\expect( 'wp_style_is' )
			->with( $styleHandle, 'registered' )
			->andReturn( $alreadyRegistered );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$style  = new Style( $styleHandle, $path, $dependencies, $media, $uriGen );
		$result = $style->isRegistered();
		$this->assertSame( $alreadyRegistered, $result );

	}

	public function defaultTestData() {

		$data = [];

		$data['Test 1'] = [
			// $styleHandle
			'foo',
			// $path
			DummyDataProvider::getScriptFile(),
			// $dependencies
			[],
			// $media
			'all',
		];

		return $data;
	}
}
