<?php

  $parent_id = wp_get_post_parent_id( $post->ID );

  $menu_japanese = ( is_page_template( 'page-japanese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-japanese.php' ) ? true : false;

  $menu_chinese = ( is_page_template( 'page-chinese.php' ) || get_post_meta( $parent_id, '_wp_page_template', true ) == 'page-chinese.php' ) ? true : false;

  $menu_translated = 'Menu';

  if( $menu_japanese ) {

    $menu_translated = 'Menu'; // @TODO need translation

  } elseif( $menu_chinese ) {

    $menu_translated = '菜单';

  }

?>


<div class="sidebar-international">
    <ul>
    <?php foreach($sidebar_links as $link): ?>
        <li class="<?= ($link['active']) ? "active" : ""; ?>"><a href="<?= $link['link']; ?>"><?= $link['title']; ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>

<div class="sidebar-international-mobile">

  <select id="international-page">

    <option value="0"><?= $menu_translated; ?></option>
    <?php foreach($sidebar_links as $link): ?>
        <option value="<?php echo $link['link']; ?>"><?= $link['title']; ?><?= ($link['active']) ? " - " : ""; ?></option>
    <?php endforeach; ?>

  </select>
</div>
