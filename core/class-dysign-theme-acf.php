<?php

class Dysign_Theme_ACF {
  
  const ACF = "acf-pro/acf.php";
  
  public function execute() {
    $this->register_hooks();
  }  

  protected function register_hooks() {
    add_filter('plugin_action_links', array($this, 'disallow_acf_deactivation'), 10, 4); 
    add_filter('acf/settings/save_json', array($this, 'acf_json_save_groups'));
    //add_action('init', array($this, 'set_options_pages'));
  }

  function disallow_acf_deactivation($actions, $plugin_file, $plugin_data, $context) {  
    if (array_key_exists('deactivate', $actions) and $plugin_file == self::ACF) {
      unset( $actions['deactivate'] );
    } 
    return $actions;
  } 

  public function json_save_groups($path) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
  }

  public function set_options_pages() {
    acf_add_options_page(array(
      'page_title'    => 'Theme Options',
      'menu_title'    => 'Theme Options',
      'menu_slug'     => 'dysign-options',
      'capability'    => 'edit_posts',
      'position'      => 3,
      'icon_url'      => 'dashicons-welcome-widgets-menus'
    ));

    acf_add_options_sub_page(array(
      'page_title'    => 'Header',
      'menu_title'    => 'Header',
      'parent_slug'   => 'dysign-options',
    ));

    acf_add_options_sub_page(array(
      'page_title'    => 'Blog',
      'menu_title'    => 'Blog',
      'parent_slug'   => 'dysign-options',
    ));

    acf_add_options_sub_page(array(
      'page_title'    => 'Footer',
      'menu_title'    => 'Footer',
      'parent_slug'   => 'dysign-options',
    ));
  }
}