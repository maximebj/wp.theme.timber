<?php

// Composer
require_once(__DIR__ . '/vendor/autoload.php');

// Timber
$timber = new \Timber\Timber();


// Hooks
include get_template_directory().'/core/class-dysign-theme-hooks.php';
$dysign_theme_hooks = new Dysign_Theme_Hooks();
$dysign_theme_hooks->execute();

// Post Types
include get_template_directory().'/core/class-dysign-theme-cpt.php';
$dysign_theme_cpt = new Dysign_Theme_CPT();
$dysign_theme_cpt->execute();

// Theme features
include get_template_directory().'/core/class-dysign-theme-features.php';
$dysign_theme_features = new Dysign_Theme_Features();
$dysign_theme_features->execute();

// ACF
include get_template_directory().'/core/class-dysign-theme-acf.php';
$dysign_theme_acf = new Dysign_Theme_ACF();
$dysign_theme_acf->execute();

// Ajax
include get_template_directory().'/core/class-dysign-theme-ajax.php';
$dysign_theme_ajax = new Dysign_Theme_Ajax();
$dysign_theme_ajax->execute();

// Plugins
include get_template_directory().'/core/class-dysign-theme-plugins.php';
$dysign_theme_plugins = new Dysign_Theme_Plugins();
$dysign_theme_plugins->execute();

// Timber
include get_template_directory().'/core/class-dysign-theme-timber.php';
$dysign_theme_api = new Dysign_Theme_Timber();
$dysign_theme_api->execute();

// WP API
//include get_template_directory().'/core/class-dysign-theme-api.php';
//$dysign_theme_api = new Dysign_Theme_API();
//$dysign_theme_api->execute();

// TGM Plugin Activation
include get_template_directory().'/core/class-dysign-theme-dependencies.php';
$dysign_theme_api = new Dysign_Theme_Dependencies();
$dysign_theme_api->execute();
