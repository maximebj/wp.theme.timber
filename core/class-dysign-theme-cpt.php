<?php

class Dysign_Theme_CPT {

  public function execute() {
    $this->register_hooks();
  }

  protected function register_hooks() {
    //add_action('init', array($this, 'create_post_types'));
  }

  public function create_post_types() {
    
    // Post Type
    $labels = array(
      'name' => '#CPT#s',
      'all_items' => 'Tous les #CPT#s',
      'singular_name' => '#CPT#',
      'add_new_item' => 'Ajouter un #CPT#',
      'edit_item' => 'Modifier le #CPT#',
      'menu_name' => '#CPT#s'
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor','thumbnail'),
      'menu_position' => 5,
      'menu_icon' => 'dashicons-portfolio', // https://developer.wordpress.org/resource/dashicons/
    );

    register_post_type('#CPTSLUG#',$args);

    // Taxonomy
    $labels = array('name' => '#TAXO#');
    
    register_taxonomy( '#TAXSLUG#', '#CPTSLUG#', array( 'hierarchical' => true, 'public' => true, 'labels' => $labels, 'query_var' => true ));
  }
}
