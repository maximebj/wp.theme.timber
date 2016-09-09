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
  function add_to_context( $context ) {

    // Menus
    $data['main_menu'] = new TimberMenu('main'); 
    $data['footer_menu'] = new TimberMenu('footer');

    // Sidebar
    if(is_single() or is_archive() or is_home() or is_front_page()):
      $data['sidebar'] = Timber::get_widgets('Blog');
    endif;

    return $context;
  }

  // Improve Twig
  public function add_to_twig($twig) {
    // this is where you can add your own functions to twig
    //$twig->addExtension( new Twig_Extension_StringLoader() );
    //$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));

    return $twig;
  }

  // Demo Twig filter
  public function filter($text) {
    $text .= ' <= Timber custom-filtered thing!';

    return $text;
  }

}