<?php
/**
/*
Plugin Name: Gutenberg Pack
Plugin URI: https://wordpress.org/plugins/gutenberg-pack/
Description: A beautiful collection of handy Gutenberg blocks to help you get started with the new WordPress editor.
Version: 1.0.0
Author: Utpol Deb Nath
Author URI: https://www.facebook.com/utpol.mitu
License: GPLv2 or later
Text Domain: gutenberg-pack
*/

// Exit if accessed directly
if( !defined('ABSPATH') ){
	exit;
}


if( !function_exists('gutenberg_pack_loader' ) ){
	function gutenberg_pack_loader(){
		add_action( 'enqueue_block_editor_assets', 'gutenberg_pack_block_editor_assets');
		add_action( 'enqueue_block_assets', 'gutenberg_pack_block_assets');
	}
	add_action( 'plugins_loaded', 'gutenberg_pack_loader');
}



function gutenberg_pack_block_editor_assets(){
	wp_enqueue_script( 
		'gutenberg-pack-hello-js',
		plugins_url( '/blocks/hello/hello.js', __FILE__), 
		array( 'wp-blocks', 'wp-i18n', 'wp-element' )
	);

	wp_enqueue_style(
		'gutenberg-pack-hello-editor-css',
		plugins_url( '/blocks/hello/hello-editor.css', __FILE__),
		array( 'wp-edit-blocks')
	);
	
}


function gutenberg_pack_block_assets(){
	wp_enqueue_style(
		'gutenberg-pack-hello-css',
		plugins_url( '/blocks/hello/hello.css', __FILE__),
		array( 'wp-blocks')
	);
}



add_action( 'admin_init', 'gutenberg_pack_check_compatibility' );
function gutenberg_pack_check_compatibility(){
	global $wp_version;
	if( !version_compare( $wp_version, '5.0', '>=') && !is_plugin_active('gutenberg/gutenberg.php') ){
		deactivate_plugins( plugin_basename( __FILE__ ));
		add_action( 'admin_notices', 'gutenberg_pack_compatibility_notices');
	}

}

function gutenberg_pack_compatibility_notices(){
	?>
	<div class="error notice is-dismissible">
		<p><?php _e( 'Gutenberg Pack requires WordPress 5.0 or Gutenberg plugin to be activated', 'gutenberg-pack' ); ?></p>
	</div>
	<?php
}



add_filter( 'block_categories', function ( $categories, $post ){
    return array_merge(
	    $categories,
	    array(
		    array(
			    'slug' => 'gutenberg-block',
			    'title' => __( 'Gutenberg Block', 'gutenberg-block' )
		    ),
	    )
    );
}, 10, 2);