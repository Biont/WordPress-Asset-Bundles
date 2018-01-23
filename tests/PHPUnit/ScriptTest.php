<?php # -*- coding: utf-8 -*-
declare( strict_types=1 );

use Biont\AssetBundles\AssetUriGenerator;
use Biont\AssetBundles\Script;
use Biont\AssetBundles\Test\Helper\DummyDataProvider;
use Brain\Monkey\Functions;
use MonkeryTestCase\BrainMonkeyWpTestCase;

class ScriptTest extends BrainMonkeyWpTestCase {

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $scriptHandle
	 * @param string $path
	 */
	public function test_register(
		string $scriptHandle,
		string $path,
		array $dependencies,
		bool $inFooter,
		array $l10n
	) {

		$alreadyRegistered = (bool) random_int( 0, 1 );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		Functions\expect( 'wp_script_is' )->andReturn( $alreadyRegistered );
		Functions\expect( 'wp_register_script' )->andReturn( true );
		$script = new Script( $scriptHandle, $path, $dependencies, $inFooter, $l10n, $uriGen );
		$result = $script->register();
		$this->assertSame( true, $result );
	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $scriptHandle
	 * @param string $path
	 */
	public function test_enqueue(
		string $scriptHandle,
		string $path,
		array $dependencies,
		bool $inFooter,
		array $l10n
	) {

		$alreadyEnqueued   = (bool) random_int( 0, 1 );
		$alreadyRegistered = (bool) random_int( 0, 1 );

		Functions\expect( 'wp_script_is' )
			->with( $scriptHandle )
			->andReturn( $alreadyEnqueued );

		Functions\expect( 'wp_script_is' )
			->with( $scriptHandle, 'registered' )
			->andReturn( $alreadyRegistered );

		if ( ! $alreadyRegistered ) {
			Functions\expect( 'wp_register_script' )->andReturn( true );
		}

		if ( ! $alreadyEnqueued ) {
			Functions\expect( 'wp_enqueue_script' )->andReturn( true );
		}

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$script = new Script( $scriptHandle, $path, $dependencies, $inFooter, $l10n, $uriGen );
		$result = $script->enqueue();
		$this->assertSame( true, $result );

	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $scriptHandle
	 * @param string $path
	 */
	public function test_isEnqueued(
		string $scriptHandle,
		string $path,
		array $dependencies,
		bool $inFooter,
		array $l10n
	) {

		$alreadyEnqueued = (bool) random_int( 0, 1 );
		Functions\expect( 'wp_script_is' )
			->with( $scriptHandle )
			->andReturn( $alreadyEnqueued );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$script = new Script( $scriptHandle, $path, $dependencies, $inFooter, $l10n, $uriGen );
		$result = $script->isEnqueued();
		$this->assertSame( $alreadyEnqueued, $result );

	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $scriptHandle
	 * @param string $path
	 */
	public function test_isRegistered(
		string $scriptHandle,
		string $path,
		array $dependencies,
		bool $inFooter,
		array $l10n
	) {


		$alreadyRegistered = (bool) random_int( 0, 1 );
		Functions\expect( 'wp_script_is' )
			->with( $scriptHandle, 'registered' )
			->andReturn( $alreadyRegistered );

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );
		$script = new Script( $scriptHandle, $path, $dependencies, $inFooter, $l10n, $uriGen );
		$result = $script->isRegistered();
		$this->assertSame( $alreadyRegistered, $result );

	}

	/**
	 * @dataProvider defaultTestData
	 *
	 * @param string $scriptHandle
	 * @param string $path
	 */
	public function test_localize(
		string $scriptHandle,
		string $path,
		array $dependencies,
		bool $inFooter,
		array $l10n
	) {

		$l10n = [
			'foo' => [ 'bar' => 'baz' ],
		];

		$uriGen = Mockery::mock( AssetUriGenerator::class );
		$uriGen->shouldReceive( 'getUri' )
		       ->andReturn( 'yay' );

		Functions\expect( 'wp_localize_script' )
			->atLeast( count( $l10n ) )
			->andReturn( true );

		$script = new Script( $scriptHandle, $path, $dependencies, $inFooter, $l10n, $uriGen );
		$result = $script->localize();
		$this->assertTrue( $result );
	}

	public function defaultTestData() {

		$data = [];

		$data['Test 1'] = [
			// $scriptHandle
			'foo',
			// $path
			DummyDataProvider::getScriptFile(),
			// $dependencies
			[],
			// $inFooter
			true,
			//$l10n
			[],
			// $wpScriptIsResult
			(bool) random_int( 0, 1 ),

		];

		return $data;
	}
}
