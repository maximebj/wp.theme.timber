<?php

namespace DysignTheme\Core;

class Config {

  public function execute() {
    $this->register_hooks();
    $this->clean_wp();
  }

  public function register_hooks() {

    if( defined('MAINTENANCE') and MAINTENANCE ) {
      add_action( 'get_header', array( $this, 'activate_maintenance' ) );
    }

    // Public Hooks

    add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
    add_action( 'init', array( $this, 'change_author_permalinks' ) );

    //add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
    //add_filter( 'excerpt_length', array( $this, 'set_excerpt_length' ) );
    //add_filter( 'excerpt_more', array( $this, 'set_excerpt_suffixe' ) );
    //add_action( 'wp_print_scripts', array( $this, 'dequeue_scripts'), 100 );


    // Admin Hooks

    add_action( 'admin_menu', array( $this, 'remove_meta_boxes' ) );
    add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_dysign_widget'), 1 );
    add_filter( 'admin_footer_text', array( $this, 'change_footer' ) );
    add_filter( 'sanitize_file_name', 'remove_accents' );

    //add_action( 'admin_menu', array( $this, 'remove_menu_pages' ) );
    //add_filter( 'upload_mimes', array( $this, 'allow_mime_types' ) );
    //add_action( 'admin_enqueue_scripts', array( $this, 'admin_theme_style' ) );

  }


  public function clean_wp() {

    // Remove XML RPC
    add_filter( 'xmlrpc_enabled', '__return_false' );

    // Welcome panel
    remove_action( 'welcome_panel', 'wp_welcome_panel' );

    // Head useless stuff
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'feed_links', 2);
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'feed_links_extra', 3);
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0);
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0);
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0);

    // Remove Emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  }


  /*  ===============  */
  /*  = Main config =  */
  /*  ===============  */

  public function theme_setup() {

    // Text Domain
    load_theme_textdomain( 'dysign', get_template_directory() . '/languages' );

    //  Thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 800, 600, false );
    add_image_size( 'fullwidth', 1920, 0, false );

    //  Page Title
    add_theme_support( 'title-tag' );

    // Menus
    register_nav_menus( array(
      'main' => 'Menu Principal',
      'footer' => 'Pied de page'
    ) );

    // Editor custom styles
    add_theme_support( 'editor-styles' );
    add_editor_style( array( 'css/editor-style.css' ) );

    // Enable HTML5
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
    ) );

    // RSS
    add_theme_support( 'automatic-feed-links' );

    // Gutenberg - Wide blocks
    add_theme_support( 'align-wide' );

  }

  public function register_assets() {

    wp_deregister_script( 'jquery' );
  
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, '3.3.1', true);
    wp_enqueue_script( 'dysign', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true );
  
    wp_enqueue_style( 'dysign', get_template_directory_uri() . '/css/main.css', array(), '1.0' );
  }

  public function change_author_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'auteur';
  }

  public function register_sidebars() {
    register_sidebar(array(
      'name' => 'Blog',
      'before_widget'  => '<div class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title' => '<p>',
      'after_title' => '</p>'
    ));
  }

  public function set_excerpt_length($length) {
    return 20;
  }

  public function set_excerpt_suffixe($more) {
    return '…';
  }

  public function dequeue_scripts() {
    //wp_dequeue_script('' );
    //wp_dequeue_syle('' );
  }



  /*  ===================  */
  /*  = Admin Functions =  */
  /*  ===================  */

  public function remove_meta_boxes() {
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' ); // WP News
  }

  public function add_dashboard_dysign_widget() {
    wp_add_dashboard_widget( 'dysign_dashboard_widget', 'Dysign', array( $this, 'dysign_dashboard_widget_function' ) );
  }

  public function dysign_dashboard_widget_function( $post, $callback_args ) {

    $html = '
      <p>Votre site est géré par <strong>Maxime BERNARD-JACQUET</strong>.</p>
      <p style="text-align: center"><a href="http://dysign.fr"><img src="' . get_bloginfo('template_url') . '/img/dysign.png" style="width:150px"></a></p>
      <p><strong>Me contacter :</strong>
      <p>Maxime BERNARD-JACQUET<br>
      06 74 14 03 49<br>
      <a href="mailto:maxime@dysign.fr">maxime@dysign.fr</a>';

    echo $html;
  }

  public function change_footer() {
    $html = 'Crée par <a href="http://www.dysign.fr/" target="_blank">Dysign</a>, propulsé par <a href="http://wordpress.org" target="_blank">WordPress</a>';

    echo $html;
  }

  public function remove_menu_pages() {
    $current_user = wp_get_current_user();

    if( $current_user->ID != 1 ) {

      remove_menu_page( 'tools.php' );
      remove_menu_page( 'edit-comments.php' );

      remove_submenu_page( 'themes.php', 'widgets.php' );
      remove_submenu_page( 'themes.php', 'theme-editor.php' );

      remove_menu_page( 'users.php' );

      remove_menu_page( 'wpcf7' ); // Contact form 7
      remove_menu_page( 'gf_edit_forms' ); // gravity forms
      remove_menu_page( 'wpseo_dashboard' ); // SEO by Yoast

      remove_menu_page( 'edit.php?post_type=acf' ); // Advanced Custom Fields
    }
  }

  public function allow_mime_types($mimes){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }

  public function admin_theme_style() {
    wp_enqueue_style( 'custom-admin', get_template_directory_uri().'/css/admin.css' );
  }

  /*  ====================  */
  /*  = Global Functions =  */
  /*  ====================  */

  public function activate_maintenance() {
    if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
      wp_die( 'Site en maintenance.' );
    }
  }
}
