<?php get_header(); ?>

<h1 class="title-page">
  <?php if( is_author() ): ?>
    Author: <?php echo $author_name ?>
  <?php elseif( is_category() ): ?>
    Category: <?php single_cat_title(); ?>
  <?php elseif( is_tag() ): ?>
    Tag: <?php single_tag_title(); ?>
  <?php elseif( is_year() ): ?>
    Видеоархив for <?php the_time('Y'); ?>
  <?php elseif( is_month() ): ?>
    Видеоархив for <?php the_time('F Y'); ?>
  <?php else: ?>
    Видеоархив
  <?php endif; ?>
</h1>
<div class="container">
<?php get_sidebar(); ?>

  <section class="film-list right-content" id="response-data">
      <?php if ( have_posts() ): ?>
        <?php while ( have_posts() ) : the_post(); ?>
        <article class="film-poster">
            <header class="article-header">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </header>
            <div class="film-image">
              <?php the_post_thumbnail(array( 265, 200 ), array('class' => 'card-img-top') ); ?>
            </div>
            <section class="article-description">
              <div class="film-short-description"><?php the_excerpt(); ?></div>
              <div class="terms-item">
                <strong>Стоимость: </strong>
                <?php echo get_post_meta( get_the_ID(), 'price_film', true ) ?>
                <span>руб </span>
              </div>
              <div class="terms-item">
                <strong>Дата выхода: </strong>
                <?php echo get_post_meta( get_the_ID(), 'date_film', true ) ?>
                <span>год </span>
              </div>
              <div class="terms-item">
                <strong>Страна: </strong>
                <?php
                  $terms = get_the_terms( $post->ID, 'films_country' ); 
                  foreach ($terms as $row) { echo $row->name . "  "; }
                ?>
              </div>
              <div class="terms-item">
                <strong>Жанр фильма: </strong>
                <?php
                  $terms = get_the_terms( $post->ID, 'films_genre' ); 
                  foreach ($terms as $row) { echo $row->name . "  "; }
                ?>
              </div>
              <div class="terms-item">
                <strong>Актерскй состав: </strong>
                <?php
                  $terms = get_the_terms( $post->ID, 'films_actors' ); 
                  foreach ($terms as $row) { echo $row->name . "  "; }
                ?>
              </div>
            </section>
        </article>
        <?php endwhile; wp_reset_query(); ?>
      <?php else: ?>
        <h2>No posts found</h2>
      <?php endif; ?>
    

    <?php if ( $wp_query->max_num_pages > 1 ) : ?>
      <div class="prev">
        <?php next_posts_link( __( '&larr; Older posts' ) ); ?>
      </div>
      <div class="next">
        <?php previous_posts_link( __( 'Newer posts &rarr;' ) ); ?>
      </div>
    <?php endif; ?>

  </section>
</div>

<?php get_footer(); ?>