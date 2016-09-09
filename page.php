<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();

// Look for a custom template
if($slug = get_page_template_slug($post->ID) != '') {
  $template = "page-$slug.twig";
} else {
  $template = 'page.twig';
}

Timber::render($template, $context);
