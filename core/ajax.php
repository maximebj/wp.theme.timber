<?php

namespace DysignTheme\Core;

class Ajax {

  public function execute() {
    $this->register_hooks();
  }

  protected function register_hooks() {
    // add_action('wp_ajax_dysign_theme_search', array($this, 'search'));
    // add_action('wp_ajax_nopriv_dysign_theme_search', array($this, 'search'));
  }

  public function search() {
    $keyword = $_POST['keyword'];

    $args = array(
      's' => $keyword
    );

    $ajax_query = new WP_Query($args);

    if($ajax_query->have_posts()) : while($ajax_query->have_posts()) : $ajax_query->the_post();
      get_template_part('article');
    endwhile;
    endif;

    die();
  }
}

/*
  Put in Front :

  $('body').on('change', '#s', function() {
    var keyword = $(this).val();

    jQuery.post(
      ajaxurl,
      {
          'action': 'dysign_theme_search',
          'keyword': keyword
      },
      function(response){
          $('.somewhere').html(response);
      }
    );
  });
*/
