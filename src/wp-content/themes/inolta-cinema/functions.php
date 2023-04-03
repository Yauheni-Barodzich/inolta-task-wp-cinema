<?php
add_action( 'after_setup_theme', function(){
	register_nav_menus( [
		'primary' => 'Меню'
	]);
});

function register_my_widgets(){
	register_sidebar( array(
		'name' => "Левая боковая панель сайта",
		'id' => 'left-sidebar-1',
		'description' => 'Эти виджеты будут показаны в левой колонке сайта',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	) );
}
add_action( 'widgets_init', 'register_my_widgets' );

add_theme_support( 'post-thumbnails' );
add_theme_support( 'nav-menus' );
add_theme_support( 'menus' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-formats');

function head_init_method() {
  if( !is_admin() ) {
    wp_register_script( 'lib', get_bloginfo('template_directory') . '/assets/libs/jquery/dist/jquery.min.js');
    wp_register_script( 'global', get_bloginfo('template_directory') . '/assets/js/scripts.min.js');
    wp_register_style( 'reset', get_bloginfo('template_directory') . '/assets/css/reset.css');
    wp_register_style( 'global', get_bloginfo('template_directory') . '/assets/css/style.min.css');
    wp_enqueue_script('lib');
    wp_enqueue_script('global');
    wp_enqueue_style( 'reset' );
    wp_enqueue_style( 'global' );
  }
}

function add_films_type() {
  $args = array(
    'label'  => null,
    'labels' => [
      'name'               => 'Фильмы',
      'singular_name'      => 'Фильм',
      'add_new'            => 'Добавить фильм',
      'add_new_item'       => 'Добавление фильма',
      'edit_item'          => 'Редактирование фильма',
      'new_item'           => 'Новое фильм',
      'view_item'          => 'Смотреть страницу фильма',
      'search_items'       => 'Искать фильмы',
      'not_found'          => 'Фильмы не найдены',
      'not_found_in_trash' => 'Не найдено в корзине',
      'menu_name'          => 'Фильмы',
    ],
    'public'        => true,
    'show_ui'       => true,
    'show_in_menu'  => true,
    'show_in_admin_bar'  => true,
    'show_in_nav_menus'  => true,
    'menu_position'      => 2,
    'capability_type'    => 'post',
    'rewrite'       => array( 'slug' => 'films' ),
    'has_archive'   => true,
    'publicly_queryable'   => true,
    'hierarchical'  => false,
    'show_in_rest'  => true,
    'query_var'     => true,
    'rest_base'     => 'films',
    'template' => array(
      array( 'core/column', array(), array(
        array( 'core/image', array() ),
        array( 'core/paragraph', array(
          'placeholder' => 'Добавить описание к фильму'
        )),
      ))
    ),
    'template_lock '=> true,
    'description'   => 'Коллекция фильмов',
    'menu_icon'     => 'dashicons-format-video',
    'supports'      => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt', 'custom-fields', 'post-formats'),
    'taxonomies'    => array('films_genre', 'films_country', 'films_actors')
  );
  register_post_type( 'films', $args );
}

function films_taxonomy() {
  register_taxonomy( 'films_genre', 'films',
      array(
      'labels' => array(
          'name'              => 'Жанры',
          'singular_name'     => 'Жанр',
          'search_items'      => 'Поиск жанров',
          'all_items'         => 'Все жанры',
          'edit_item'         => 'Редактировать жанр',
          'update_item'       => 'Обновить жанр',
          'add_new_item'      => 'Добавить новый жанр',
          'new_item_name'     => 'Новое имя жанра',
          'menu_name'         => 'Жанры',
          ),
      'hierarchical' => true,
      'sort'    => true,
      'public'  => true,
      'show_in_rest'  => true,
      'query_var'     => 'genre',
      'show_tagcloud' => true,
      'capabilities'  => array(),
      'rest_controller_class' => 'WP_REST_Terms_Controller',
      'args'    => array( 'orderby' => 'term_order' ),
      'rewrite' => array( 'slug' => 'genre' ),
      'show_admin_column' => true
      )
  );
  register_taxonomy( 'films_country', 'films',
      array(
      'labels' => array(
          'name'              => 'Страны',
          'singular_name'     => 'Страна',
          'search_items'      => 'Поиск стран',
          'all_items'         => 'Все страны',
          'edit_item'         => 'Редактировать страну',
          'update_item'       => 'Обновить страну',
          'add_new_item'      => 'Добавить новую страну',
          'new_item_name'     => 'Новое имя страны',
          'menu_name'         => 'Страны',
          ),
      'hierarchical' => true,
      'sort' => true,
      'public'  => true,
      'show_in_rest'  => true,
      'show_tagcloud' => true,
      'capabilities'  => array(),
      'rest_controller_class' => 'WP_REST_Terms_Controller',
      'args' => array( 'orderby' => 'term_order' ),
      'rewrite' => array( 'slug' => 'country' ),
      'show_admin_column' => true
      )
  );
  register_taxonomy( 'films_actors', 'films',
      array(
      'labels' => array(
          'name'              => 'Актеры',
          'singular_name'     => 'Актер',
          'search_items'      => 'Поиск по актерам',
          'all_items'         => 'Все актеры',
          'edit_item'         => 'Редактировать актера',
          'update_item'       => 'Обновить актера',
          'add_new_item'      => 'Добавить нового актера',
          'new_item_name'     => 'Новое имя актера',
          'menu_name'         => 'Актеры',
          ),
      'hierarchical' => true,
      'sort' => true,
      'public'  => true,
      'show_in_rest'  => true,
      'show_tagcloud' => true,
      'capabilities'  => array(),
      'rest_controller_class' => 'WP_REST_Terms_Controller',
      'args' => array( 'orderby' => 'term_order' ),
      'rewrite' => array( 'slug' => 'actors' ),
      'show_admin_column' => true
      )
  );
}

function add_meta_films() {
    add_meta_box( 'film_meta_box', 'Дополнительная информация', 'meta_films_template', 'films', 'normal', 'high' );
}

function meta_films_template ( $film ) {
  $price = esc_html( get_post_meta( $film->ID, 'price_film', true ) );
  $date = esc_html( get_post_meta( $film->ID, 'date_film', true ) );
  ?>        
    <table>
      <tr>
        <td style="width: 100%">Стоимость фильма:</td>
        <td><input type="number" min="0.00" max="1000" step="1" name="price_film" value="<?php echo $price; ?>" /></td>
        <td>руб</td>
      </tr>
      <tr>
        <td style="width: 150px">Дата выхода фильма:</td>
        <td><input type="number" name="date_film" min="1900" max="2099" step="1" value="<?php echo $date; ?>" /></td>
        <td>год</td>
      </tr>
    </table>
  <?php
}

function add_film_fields( $film_id, $film ) {
  if ( $film->post_type == 'films' ) {
      if ( isset( $_POST['price_film'] ) && $_POST['price_film'] != '' ) {
          update_post_meta( $film_id, 'price_film', $_POST['price_film'] );
      }
      if ( isset( $_POST['date_film'] ) && $_POST['date_film'] != '' ) {
          update_post_meta( $film_id, 'date_film', $_POST['date_film'] );
      }
  }
}

function add_template_films( $template_path ) {
  global $post;
 
  return $template_path;
}

function true_taxonomy_filter() {
  global $typenow; // тип поста
  if( $typenow == 'films' ){
    $taxes = array('films_country', 'films_genre', 'films_actors');
    foreach ($taxes as $tax) {
      $current_tax = isset( $_GET[$tax] ) ? $_GET[$tax] : '';
      $tax_obj = get_taxonomy($tax);
      $tax_name = mb_strtolower($tax_obj->labels->name);
      $terms = get_terms($tax);
      if(count($terms) > 0) {
        echo "<select name='$tax' id='$tax' class='postform'>";
        echo "<option value=''>Все $tax_name</option>";
        foreach ($terms as $term) {
          echo '<option value='. $term->slug, $current_tax == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
        }
        echo "</select>";
      }
    }
  }
}

function filter_films(){
  echo '<form class="filter-form" action="/wp-admin/admin-ajax.php" method="POST" id="filter">';
		if( $terms = get_terms( array( 'taxonomy' => 'films_genre', 'orderby' => 'name' ) ) ) {
      echo '<div class="filter-title">Выберите жанр: </div>';
			foreach ( $terms as $term ) {
        echo '<div class="filter-item"><label> <input type="checkbox" name="genre[]" value="' . $term->name . '"> <span>' . $term->name . '</span> </label></div>';
      }
    }
    if( $terms = get_terms( array( 'taxonomy' => 'films_country', 'orderby' => 'name' ) ) ) {
      echo '<div class="filter-title">Выберите страну: </div>';
			foreach ( $terms as $term ) {
        echo '<div class="filter-item"><label> <input type="checkbox" name="country[]" value="' . $term->name . '"> <span>' . $term->name . '</span> </label></div>';
      }
    }
    if( $terms = get_terms( array( 'taxonomy' => 'films_actors', 'orderby' => 'name' ) ) ) {
      echo '<div class="filter-title">Выберите актеров: </div>';
			foreach ( $terms as $term ) {
        echo '<div class="filter-item"></div><label> <input type="checkbox" name="actors[]" value="' . $term->name . '"> <span>' . $term->name . '</span> </label>';
      }
    }
    ?>
    <div class="filter-title">Диапазон стоимости:</div>
    <div class="filter-item"><input class="input-text" type="number" min="0" step="1" name="price_min" value="0" placeholder="Минимум" /></div>
	  <div class="filter-item"><input class="input-text" type="number" max="1000" step="1" name="price_max" value="1000" placeholder="Максимум" /></div>
    
    <div class="filter-title">Выберите год выпуска:</div>
    <div class="filter-item"><input class="input-text" type="number" min="0" step="1" name="date_min" value="1900" /></div>
	  <div class="filter-item"><input class="input-text" type="number" max="2099" step="1" name="date_max" value="2099"" /></div>

    <div class="filter-title">Выберите сортирвку:</div>
    <label class="filter-item"> <input type="radio" name="orderby" value="price_film" checked /> По цене </label><br>
    <label class="filter-item"> <input type="radio" name="orderby" value="date_film" /> По дате </label>

    <div class="filter-title">Порядок сортировки:</div>
    <label class="filter-item"> <input type="radio" name="order" value="ASC" checked /> По возрастанию </label><br>
    <label class="filter-item"> <input type="radio" name="order" value="DESC" /> По убыванию </label>

    <button class="filter-item filter-submit">Поиск фильмов</button>
    <input type="hidden" name="action" value="filmfilter"></form>
  <?php
}

function redefining_films_query($query) {
  if ($query->is_category) { 
    $query->set('post_type', array('films'));
  }
  return $query;
}

add_action('wp_ajax_filmfilter', 'filter_function');
add_action('wp_ajax_nopriv_filmfilter', 'filter_function');

function filter_function(){
	$args = array(
    'post_type' => 'films',
    'meta_key' => $_POST['orderby'],
		'orderby' => 'meta_value_num',
		'order'	=> $_POST['order'],
    'posts_per_page' => -1,
	);
  if( isset( $_POST['genre'] ) ) {
    $args['tax_query'] = array(
			array(
				'taxonomy' => 'films_genre',
				'field' => 'name',
				'terms' => $_POST['genre'],
			)
		);
  };
  if( isset( $_POST['country'] ) ) {
    $args['tax_query'] = array(
			array(
				'taxonomy' => 'films_country',
				'field' => 'name',
				'terms' => $_POST['country'],
			)
		);
  };
  if( isset( $_POST['actors'] ) ) {
    $args['tax_query'] = array(
			array(
				'taxonomy' => 'films_actors',
				'field' => 'name',
				'terms' => $_POST['actors'],
			)
		);
  };

 // Выборка по году стоимости
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] )
		$args['meta_query'] = array( 'relation'=>'AND' );
 
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => 'price_film',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => 'price_film',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => 'price_film',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}

  // Выборка по году выпуска
  if( isset( $_POST['date_min'] ) && $_POST['date_min'] || isset( $_POST['date_max'] ) && $_POST['date_max'] )
		$args['meta_query'] = array( 'relation'=>'AND' );
 
	if( isset( $_POST['date_min'] ) && $_POST['date_min'] && isset( $_POST['date_max'] ) && $_POST['date_max'] ) {
		$args['meta_query'][] = array(
			'key' => 'date_film',
			'value' => array( $_POST['date_min'], $_POST['date_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		if( isset( $_POST['date_min'] ) && $_POST['date_min'] )
			$args['meta_query'][] = array(
				'key' => 'date_film',
				'value' => $_POST['date_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		if( isset( $_POST['date_max'] ) && $_POST['date_max'] )
			$args['meta_query'][] = array(
				'key' => 'date_film',
				'value' => $_POST['date_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}
	$query = new WP_Query( $args );
	
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
    ?>
      <article class="film-poster">
            <header class="article-header">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </header>
            <?php the_post_thumbnail(array( 265, 200 ), array('class' => 'card-img-top') ); ?>
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
        <?php
		endwhile;
		wp_reset_postdata();
	else :
		echo 'Фильмы не найдены';
	endif;
	
	die();
}

add_action( 'pre_get_posts', 'set_index_page_films' );
function set_index_page_films( $query ) {
    if( $query->is_main_query() && $query->is_home() ) {
        $query->set( 'post_type', array('films') );
    }
}

add_action( 'init', 'head_init_method' );
add_action( 'init', 'add_films_type' );
add_action( 'init', 'films_taxonomy');
add_action( 'admin_init', 'add_meta_films' );
add_action( 'save_post', 'add_film_fields', 10, 2 );
add_action( 'restrict_manage_posts', 'true_taxonomy_filter' );
//add_filter( 'template_include', 'add_template_films' );
add_filter('pre_get_posts', 'redefining_films_query');
add_shortcode( 'filter_films_block', 'filter_films' );