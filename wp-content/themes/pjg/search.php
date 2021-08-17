<?php
/**
 * The template for displaying search results
 *
 * @package pjg
 */

get_header();

global $search_query;
$search_query = $wp_query->query_vars['s'];
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main the-blue-bar" role="main">
      <div class="archive-title">
        <header class="entry-header">
          <div class="inner">

            <h1 class="entry-title">Search Results</h1>

          </div>
        </header><!-- .page-header -->

      </div>
        <div class="search-content">

          <h4 class="search-form-title has-the-blue-bar">Showing Search Results For:</h4>

            <?php get_search_form(); ?>

            <div class="wrapper-posts wrapper-search">

            <?php get_template_part( 'partials/search', 'results' ); ?>


            </div>


        </div><!-- .page-content -->

    </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
