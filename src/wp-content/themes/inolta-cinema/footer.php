<footer class="footer-page">
    <?php wp_footer(); ?>

    <?php wp_nav_menu( [
      'theme_location'  => '',
      'menu'            => 'primary',
      'container'       => 'nav',
      'container_class' => 'menu-footer',
      'container_id'    => '',
      'menu_class'      => 'menu-footer-list',
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
</footer>
</body>
</html>