<?php
/**
 * Visitor Info Fat Footer Widget
 */
$day_schedule = $day_schedule ?: pjg_get_day_schedule();
?>

<section class="footer-visitor widget visitor-info">
  <div class="container">
    <div class="widget-hours-admission columns 5-large">
      <div class="vert">
        <?php if(is_array($day_schedule)): ?>
          <div class="row">
            <div class="widget-schedule">
              <p class="surtitle"><?= ucfirst(date('l')) ?>'s <?= ucfirst(pjg_get_season()) ?> Hours</p>
              <h2 class="widget-title"> <?= ( $day_schedule['currenty_closed'] ) ? 'CLOSED' : $day_schedule['public_display']; ?></h2>
              <?php if($day_schedule['member_display']): ?>
              <p class="subtitle">Member Hours: <?= $day_schedule['member_display'] ?></p>
              <?php endif; ?>
              <p class="legal-text"><?= get_field('hour_legal', 'option')?></p>
            </div>
            <?php endif; ?>
            <div class="widget-prices">
              <p class="surtitle">Admission</p>
              <h2 class="widget-title"><?= get_field('price_cost_default', 'option') ?></h2>
              <p class="subtitle">Adult Ticket Price</p>
              <p class="legal-text">Additional Pricing Available</p>
            </div>

          </div>

        <a class="button" href="<?= get_permalink(get_page_by_path('hours-admission') )?>">View All Hours &amp; Ticket Prices</a>

      </div>
    </div>
    <div class="promo-wrapper">
      <div class="promo middle columns 3-large">
        <div class="vert">
          <p class="surtitle"><?= get_field('promo_headline_first', 'option') ?></p>
          <h2 class="widget-title"><?= get_field('description_short_top_first', 'option') ?></h2>
          <p class="subtitle"><?= get_field('description_short_bottom_first', 'option') ?></p>
          <?php
          $button_text = get_field('button_copy_first', 'option');
          $button_url = get_field('button_url_first', 'option');
          if($button_text && $button_url): ?>
            <a class="button" href="<?= $button_url ?>"><?= $button_text ?></a>
          <?php endif; ?>

        </div>
      </div>
      <div class="promo columns 4-large last">
        <div class="vert">
          <p class="surtitle"><?= get_field('promo_headline_second', 'option') ?></p>
          <h2 class="widget-title"><?= get_field('description_short_top_second', 'option') ?></h2>
          <p class="subtitle"><?= get_field('description_short_bottom_second', 'option') ?></p>
          <?php
          $button_text = get_field('button_copy_second', 'option');
          $button_url = get_field('button_url_second', 'option');
          if($button_text && $button_url): ?>
            <a class="button" href="<?= $button_url ?>"><?= $button_text ?></a>
          <?php endif; ?>

        </div>
      </div>

    </div>

  </div>
</section>
