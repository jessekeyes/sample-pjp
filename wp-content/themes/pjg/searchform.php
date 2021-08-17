<?php
/**
 * search form template
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pjg
 */

global $wp_query;
?>

<form role="search" method="get" class="search-form" action="/">
  <label class="search-label" for="search-field">Search Portland Japanese Garden</label>

  <input type="search" class="search-field" placeholder="Enter search terms..."
         value="<?= htmlspecialchars($wp_query->query_vars['s']); ?>" name="s" />

  <input type="submit" class="search-submit" value="Search" />
</form>
