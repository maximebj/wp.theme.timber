<?php

$context = Timber::get_context();

$template = 'archive.twig';

// Define title
if (is_day()) {
  $context['title'] = 'Archive: '.get_the_date( 'D M Y' );
}
elseif(is_month()) {
  $context['title'] = 'Archive: '.get_the_date( 'M Y' );
}
elseif(is_year()) {
  $context['title'] = 'Archive: '.get_the_date( 'Y' );
}
elseif (is_tag()) {
  $context['title'] = single_tag_title( '', false );
}
elseif (is_category()  {
  $context['title'] = 'Catégorie &bullet; '.single_cat_title( '', false );
}
elseif(is_post_type_archive()) {
  $context['title'] = post_type_archive_title( '', false );
  $template = 'archive-' . get_post_type() . '.twig';
}
elseif(is_tax()){
  $queried_object = $wp_query->get_queried_object();
  $taxonomy = $queried_object->taxonomy;
  $tax_object = get_taxonomy($taxonomy);
  $custom_type = $tax_object->object_type[0];

  if($custom_type != "post"){
    $template = 'archive-'.$custom_type.'.twig';
  }
}
elseif(is_search()) {
  $context['title'] = "Recherche &bullet; ".get_search_query();
}
else {
  $context['title'] = 'Le Blog';
}

// This Page (for ACF fields)
$context['page'] = new TimberPost(get_option('page_for_posts'));

// Posts
$context['posts'] = Timber::get_posts();

// Pagination
$context['pagination'] = Timber::get_pagination();


Timber::render($template, $context);
