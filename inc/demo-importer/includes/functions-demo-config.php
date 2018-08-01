<?php
/**
 * Functions for configuring demo importer.
 *
 * @package Importer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup demo importer packages.
 *
 * @deprecated 1.5.0
 *
 * @param  array $packages Demo packages.
 *
 * @return array
 */
function suffice_demo_importer_packages( $packages ) {
	$new_packages = array(
		'suffice-free'             => array(
			'name'    => __( 'Suffice', 'suffice' ),
			'preview' => 'https://demo.themegrill.com/suffice/',
		),
		'suffice-pro'              => array(
			'name'     => __( 'Suffice Pro', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-app'          => array(
			'name'     => __( 'Suffice Pro App', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-app/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-construction' => array(
			'name'     => __( 'Suffice Pro Construction', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-construction/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-food'         => array(
			'name'     => __( 'Suffice Pro Food', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-food/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-gym'          => array(
			'name'     => __( 'Suffice Pro Gym', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-gym/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-magazine'     => array(
			'name'     => __( 'Suffice Pro Magazine', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-magazine/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-one-page'     => array(
			'name'     => __( 'Suffice Pro One Page', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-one-page/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-photography'  => array(
			'name'     => __( 'Suffice Pro Photography', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-photography/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-portfolio'    => array(
			'name'     => __( 'Suffice Pro Portfolio', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-portfolio/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
		'suffice-pro-shop'         => array(
			'name'     => __( 'Suffice Pro Shop', 'suffice' ),
			'preview'  => 'https://demo.themegrill.com/suffice-pro-shop/',
			'pro_link' => 'https://themegrill.com/themes/suffice/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'suffice_demo_importer_packages' );
