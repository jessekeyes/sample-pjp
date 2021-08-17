<?php
/**
 * Visitor Info Widget
 */
$schedule = pjg_get_week_schedule();
?>

</div><!-- / entry-title -->
<?php if( is_single() ) echo '</div><!-- / event-wrapper -->'; ?>
<section class="visitor-info widget widget-shortcode">
  <div class="container">
    <div class="times-wrapper">
      <div class="widget-schedule columns 3-large">
        <p class="surtitle"><?= ucfirst(pjg_get_season()) ?> Hours</p>
        <ul class="schedule-list">
        <?php foreach($schedule as $day): ?>
          <li <?= $day['is_current_day'] ? 'class="active"' : "" ?>><strong><?= ucfirst($day['day']) ?>:</strong> <?= ( $day['currenty_closed'] ) ? 'CLOSED' : $day['public_display'] ?></li>
        <?php endforeach; ?>
        </ul>
        <p class="legal-text"><?= get_field('hour_legal', 'option')?></p>
      </div>
      <div class="widget-prices columns 3-large">
        <p class="surtitle">Admission Prices</p>
        <ul class="price-list">
          <li><strong><?= get_field('price_title_default', 'option') ?>:</strong> <?= get_field('price_cost_default', 'option') ?></li>
          <?php while(have_rows('additional_prices', 'option')): the_row(); ?>
            <li><strong><?= get_sub_field('price_title', 'option') ?>:</strong> <?= get_sub_field('price_cost', 'option') ?></li>
          <?php endwhile; ?>
        </ul>
        <p class="legal-text"><?= get_field('price_legal', 'option')?></p>
        <a class="button" href="<?= get_permalink(get_page_by_path('hours-admission') )?>">Hours &amp; Admission</a>
      </div>

    </div>
    <div class="promos columns 6-large">
      <div class="promo">
        <p class="surtitle"><?= get_field('promo_headline_first', 'option') ?></p>
        <p class="promo-description"><?= get_field('description_long_first', 'option') ?></p>
        <?php
        $button_text = get_field('button_copy_first', 'option');
        $button_url = get_field('button_url_first', 'option');
        if($button_text && $button_url): ?>
          <a class="button" href="<?= $button_url ?>"><?= $button_text ?></a>
        <?php endif; ?>
      </div>
      <div class="promo">
        <p class="surtitle"><?= get_field('promo_headline_second', 'option') ?></p>
        <p class="promo-description"><?= get_field('description_long_second', 'option') ?></p>
        <?php
        $button_text = get_field('button_copy_second', 'option');
        $button_url = get_field('button_url_second', 'option');
        if($button_text && $button_url): ?>
          <a class="button" href="<?= $button_url ?>"><?= $button_text ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if( is_single() ) echo '<div class="event-wrapper post-cta"><!-- back to .event-wrapper -->'; ?>
<div class="entry-content"><!-- and we're back -->
