<?php if ( have_posts() ) :

  while ( have_posts() ) : the_post();
    get_template_part( 'partials/content-excerpt', 'search' );
  endwhile;

  // gather pagination variables
  $page = intval( @$_GET['page'] );
  if($page <= 0) {
    $page = 1;
  }
  $page_size = pjg_searchwp_posts_per_page();
  global $search_query;

  // if there is an additional page, show the load more button
  if( $wp_query->found_posts > ($page * $page_size) ) : // only show load more on first page if there are more, we'll move to infinite scroll ?>

    <div class="pagination">
      <div class="loader lazy-hide">
          <div></div>
          <div></div>
      </div>
      <div class="load-more">
        <hr class="rule-loading">
        <a href="#" class="button load-more-action search-load-more-button" data-page="<?= $page; ?>" data-query="<?= htmlspecialchars($search_query); ?>">Load More Results</a>
        <hr class="rule-loading">
      </div>
    </div>


  <?php endif;

  wp_reset_postdata();

else: ?>
  No matches found
<?php endif; ?>
