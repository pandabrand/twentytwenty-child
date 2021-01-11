<?php

add_action( 'wp_enqueue_scripts', 'tt_child_enqueue_parent_styles' );

function tt_child_enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'flickity-style', 'https://unpkg.com/flickity@2/dist/flickity.min.css' );
	wp_enqueue_script( 'flickity-script', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array(), null );
	wp_enqueue_style( 'lightbox-style', 'https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css' );
	wp_enqueue_script( 'lightbox', 'https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js', array( 'jquery' ), null, true );
	wp_enqueue_style( 'notify-style', 'https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css' );
	wp_enqueue_script( 'notify', 'https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'fww-local', get_stylesheet_directory_uri() . '/assets/js/site.js', array( 'flickity-script' ), null, true );
	wp_localize_script( 'fww-local', 'fww_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'after_theme_setup', 'paa_setup' );

function paa_setup() {
	add_image_size( 'paa-thumb', 300, 300 );
}

add_action( 'wp_ajax_nopriv_update_image', 'fww_update_image' );
add_action( 'wp_ajax_update_image', 'fww_update_image' );

function fww_update_image() {
	$photo_id   = intval( $_POST['photo_id'] );
	$post_id    = intval( $_POST['post_id'] );
	$photo_row  = intval( $_POST['photo_row'] ) + 1;
	$post_row   = intval( $_POST['paint_row'] ) + 1;
	$keep_photo = $_POST['checkbox'];
	$text       = sanitize_textarea_field( $_POST['text'] );

	$image = array(
		'image'      => $photo_id,
		'keep_photo' => $keep_photo,
		'notes'      => $text,
	);

	$paint_date = array(
		'paint_dates',
		$post_row,
		'images',
	);

	update_sub_row( $paint_date, $photo_row, $image, $post_id );

	wp_die( 'picture updated' );
}

function write_log( $log ) {
	if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) );
	} else {
			error_log( $log );
	}
}
