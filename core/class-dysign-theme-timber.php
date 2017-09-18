<?php

class Dysign_Theme_Timber extends TimberSite {

  public function execute() {
    $this->register_hooks();
  }

  private function register_hooks() {
    add_filter('timber_context', array($this, 'add_to_context'));
    add_filter('get_twig', array($this, 'add_to_twig'));
  }

  // Global context, available to all templates
  function add_to_context($context) {

    // Menus
    $context['main_menu'] = new TimberMenu('main');
    $context['footer_menu'] = new TimberMenu('footer');

    // Sidebar
    if(is_single() or is_archive() or is_home() or is_front_page()):
      $context['sidebar'] = Timber::get_widgets('Blog');
    endif;

    return $context;
  }

  // Improve Twig
  public function add_to_twig($twig) {
    $twig->addFilter('output_svg', new Twig_SimpleFilter('output_svg', array($this, 'output_svg')));

    return $twig;
  }

  // SVG embedder Twig filter
  public function output_svg($svg_url) {
    $url = get_bloginfo('template_url').'/img/'.$svg_url;
    return file_get_contents($url);
  }

}
