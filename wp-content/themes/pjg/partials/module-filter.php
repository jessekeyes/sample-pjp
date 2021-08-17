<?php
/**
 * partial renders a filter bar for ajax filtering results
 *
 * used on archives/listings
 *
 *
 * @package pjg
 */

$option_all = 'All News';
$post_type = 'post';

if( 'event' == get_query_var('post_type') || is_post_type_archive( 'event' ) || is_page( 'events' ) ) { // @TODO translate this?

  $option_all = 'All Events';
  $post_type = 'event';

}

?>

<div class="filter-bar">

  <form type="POST" id="filter" action="<?php echo ( $post_type == 'event' ) ? '/' : '/news/'; ?>">



    <?php

    $terms = get_terms( array( 'taxonomy'=>'category', 'post_type' => array( $post_type ), 'fields' => 'all', 'exclude' => 1 ) );


    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

      echo '<div class="row select row-category">';

      echo '<label for="cat">Filter By Category</label>';

      echo '<select name="cat" id="cat" class="postform select-category">';
      echo '<option value="">' . $option_all . '</option>';

      foreach ( $terms as $term ) {

        $category = get_queried_object();
        $category_id = $category->term_id;

        $selected = ( strtok($_SERVER["REQUEST_URI"],'?') != '/' && $term->term_id === $category_id  ) ? 'selected ' : ' ';

          echo '<option ' . $selected . '"' . 'class="level-0" value="' . $term->term_id . '">' . $term->name . '</option>';
      }

      echo '</select>';
      echo '</div>';
    }


    ?>

    <?php if( $post_type == 'event' ) : ?>

      <div class="row row-date-range">

        <input type="hidden" value="event" id="post_type" name="post_type" />

        <div class="date-ranger">

          <div class="row">

            <label for="start_date">Start Date</label>
            <input type="text" id="start_date" name="start_date" class="datepicker input input-date" />
            <input type="hidden" id="query_start_date" name="query_start_date" />

          </div>

          <div class="row">

            <label for="end_date">End Date</label>
            <input type="text" id="end_date" name="end_date" class="datepicker input input-date" />
            <input type="hidden" id="query_end_date" name="query_end_date" />

          </div>

        </div>

      </div>

    <?php elseif( $post_type == 'post' ) : ?>

      <div class="row row-date select">

        <div class="date-select">

          <label for="month_date">Filter By Month & Year</label>

          <select id="month_date" name="month_date" class="select-date">
            <option value=""><?php echo esc_attr( __( 'All News' ) ); ?></option>
            <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option' ) ); ?>

            <input type="hidden" id="m" name="m" value="" />

          </select>

        </div>

      </div>

    <?php endif; ?>

    <div class="row row-button">

       <input type="reset" value="Clear Filters" class="button-reset disabled" />

    </div>

  </form>




</div>
