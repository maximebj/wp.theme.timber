<?php

$context = Timber::get_context();

$context['post'] =  new TimberPost();

if (post_password_required($post->ID)) {
  $template = 'password.twig';
} else {
  $template = 'single.twig';
}

Timber::render( $template, $context );
