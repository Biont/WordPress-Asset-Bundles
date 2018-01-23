<?php # -*- coding: utf-8 -*-
declare( strict_types=1 );

namespace Biont\AssetBundles\Test\Helper;

class DummyDataProvider {

	public static function getScriptFile(): string {

		return self::getDataDir() . 'testscript.js';

	}

	public static function getStyleFile(  ) {

		return self::getDataDir() . 'teststylesheet.css';

	}

	private static function getDataDir(): string {

		return \dirname( __DIR__ ) . '/dummyData/';

	}
}
