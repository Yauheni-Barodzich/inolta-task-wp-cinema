<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <title>
    <?php
      if( ! is_home() ):
        wp_title( '|', true, 'right' );
      endif;
      bloginfo( 'name' );
    ?>
  </title>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="header-page">
  <div class="logo"><a href="/">I-Cinema</a></div>
  
  <?php wp_nav_menu( [
      'theme_location'  => '',
      'menu'            => 'primary',
      'container'       => 'nav',
      'container_class' => 'menu',
      'container_id'    => '',
      'menu_class'      => 'menu-list',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth'           => 0,
      'walker'          => '',
    ] );
  ?>

</header>