# WordPress Asset Bundles
This is a small library that allows developers to create bundles of various asset types.
Scripts, styles and other, custom asset types can be registered as a package. All assets are enqueued together when the AssetBundle is enqueued.

## Installation
Fetch this package via composer:
```composer require biont/wordpress-asset-bundles```

## Usage
```php

$bundle  => new AssetBundle( 'my_bundle', [
    new Script(
    // Script handle
    'my_asset_js',
    // Script path
    $asset_dir . 'js/asset.js',
    // Dependencies
    [ 'jquery' ]
    ),
	new Style( 'my_asset_css', $asset_dir . 'css/asset.css' ),
] );
$bundle->register();

// Call $bundle->enqueue() whenever you need your assets


```
