<?php
/**
 * Plugin Name:     ALT Login Form
 * Plugin URI:      https://github.com/altcooperativa/alt-login-form
 * Description:     WP Plugin para mostrar un form de login en cualquier parte del sitio.
 * Author:          ALT Cooperativa
 * Author URI:      https://altcooperativa.com/
 * Text Domain:     alt-login-form
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Alt_Login_Form
 */

add_action( 'init', 'alt_login_form_add_shortcodes' );

/**
 * This function adds shortcodes.
 */
function alt_login_form_add_shortcodes() {
	add_shortcode( 'alt_login_form', 'alt_login_form_print_form' );
}

/**
 * Prints a Login Form via shortcode, or a log out link in case the user is
 * logged in.
 *
 * @param arrat $atts List of arguments for the shortcode.
 *
 * @return string HTML with the form or the ancho tag to close the session.
 */
function alt_login_form_print_form( $atts ) {
	$args = shortcode_atts(
		array(
			'redirect'            => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id'             => 'loginform',
			'label_username'      => __( 'Username or Email Address' ),
			'label_password'      => __( 'Password' ),
			'label_log_in'        => __( 'Log In' ),
			'label_log_out'       => __( 'Log Out' ),
			'label_lost_password' => __( 'Forgot Your Password?' ),
			'id_username'         => 'user_login',
			'id_password'         => 'user_pass',
			'id_remember'         => 'rememberme',
			'remember'            => true,
		),
		$atts
	);

	$args['echo'] = false;

	if ( ! is_user_logged_in() ) {
		$html  = wp_login_form( $args );
		$html .= '<a class="alt-login-form-lost-password" href="';
		$html .= esc_url( site_url( 'wp-login.php?action=lostpassword' ) ) . '">';
		$html .= esc_html( $args['label_lost_password'] ) . '</a>';
	} else {
		$html  = '<a class="alt-login-form-log-out" href="';
		$html .= esc_url( wp_logout_url( home_url() ) ) . '">';
		$html .= esc_html( $args['label_log_out'] ) . '</a>';
	}

	return $html;
}



