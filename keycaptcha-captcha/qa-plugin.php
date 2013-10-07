<?php


/*
	Plugin Name: KeyCAPTCHA
	Plugin URI: 
	Plugin Description: Provides support for KeyCAPTCHA captchas
	Plugin Version: 1.0
	Plugin Date: 2013-10-02
	Plugin Author: KeyCAPTCHA
	Plugin Author URI: https://keycaptcha.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	Plugin Update Check URI:
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}


	qa_register_plugin_module('captcha', 'qa-keycaptcha-captcha.php', 'qa_keycaptcha_captcha', 'KeyCAPTCHA');
	

/*
	Omit PHP closing tag to help avoid accidental output
*/