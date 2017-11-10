<?php

class Dysign_Theme_Timber extends TimberSite {

  public function execute() {
    $this->register_hooks();

    // Define Twig directories
    Timber::$dirname = array('views', 'views/parts', 'views/ajax');
  }

  private function register_hooks() {
    add_filter('timber/context', array($this, 'add_to_context'));
    add_filter('timber/twig', array($this, 'add_to_twig'));
  }

  // Global context, available to all templates
  function add_to_context($context) {

    // WP Templates
    $context['wp']['template'] = array(
      'front_page' => is_front_page(),
      'blog' => is_home(),
    );

    // Menus
    $context['wp']['menus'] = array(
      "main" => new Timber\Menu('main'),
      "footer" => new Timber\Menu('footer'),
    );

    return $context;
  }

  // Improve Twig
  public function add_to_twig($twig) {
    $twig->addFilter(new Twig_SimpleFilter('output_svg', array($this, 'output_svg')));

    return $twig;
  }

  // SVG embedder Twig filter
  public function output_svg($svg_url) {
    $url = get_bloginfo('template_url').'/img/'.$svg_url;
    return file_get_contents($url);
  }

}
