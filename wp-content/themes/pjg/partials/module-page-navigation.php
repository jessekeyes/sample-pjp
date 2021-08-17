<?php

$pagelist = get_pages('sort_column=menu_order&sort_order=asc&parent=' . wp_get_post_parent_id(get_the_ID()));
$pages = array();

foreach ($pagelist as $page) {
   $pages[] += $page->ID;
}

// only add nav if there are at least 3 sibling pages
if(count($pages) >= 3):

$current = array_search(get_the_ID(), $pages);
$page_navigation = array();
$page_navigation['previous'] = ($current==0) ? end($pages) : $pages[$current-1];
$page_navigation['next'] = ($current+1==count($pages)) ? reset($pages) : $pages[$current+1];

$i = 0;

?>
<div class="page-navigation">
  <?php foreach( $page_navigation as $page_nav=>$page_id ): $i++;

    $featured_image = pjg_get_featured_image_excerpt( $page_id, 'child-middle' );

    if( $featured_image ) :

    ?>
    <article class="item item-overlay navigation-item">

      <div class="titles">

        <?php

          $direction = ( $i === 1 ) ? 'Previous' : 'Next';

          echo '<h4 class="sur-title">' . $direction . '</h4>';
          echo '<h1 class="entry-title">' . get_the_title( $page_id ) . '</h1>';
          echo ( get_field( 'characters', $page_id ) != '' ) ? '<div class="entry-meta kanji">' . get_field( 'characters', $page_id ) . '</div>' : '';
          echo '<div class="arrow"></div>';
        ?>

      </div>

      <a href="<?php echo get_permalink( $page_id );?>" class="permalink">

        <?php echo $featured_image; ?>

      </a>

      <div class="image-gradient"></div>

    </article>
    <?php endif; ?>
  <?php endforeach; ?>
</div>

<?php endif; ?>
