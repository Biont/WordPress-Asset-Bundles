# WordPress Asset Bundles
This is a small library that allows developers to create bundles of various asset types.
Scripts, styles and other, custom asset types can be registered as a package. All assets are enqueued together when the AssetBundle is enqueued.

## Installation
TODO

## Usage
```php

$bundle  => new AssetBundle( 'my_bundle', [
    new Script( 'my_asset_js', $asset_dir . 'js/asset.js',
        [
            BuiltinAssets::WP_CORE
        ]
    ),
	new Style( 'my_asset_css', $asset_dir . 'css/asset.css' ),
] );
$bundle->register();

// Call $bundle->enqueue() whenever you need your assets


```