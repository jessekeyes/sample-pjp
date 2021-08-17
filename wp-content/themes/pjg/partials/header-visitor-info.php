<?php
/**
 * Visitor Info Header Widget
 */
$day_schedule = $day_schedule ?: pjg_get_day_schedule();
?>

<li class="submenu-visitor visitor-info">
  <div class="hours-admission">
    <?php if(is_array($day_schedule)): ?>
    <div class="widget-schedule">
      <p class="surtitle"><?= ucfirst(date('l')) ?>'s <?= ucfirst(pjg_get_season()) ?> Garden Hours</p>
      <h2 class="widget-title"> <?= ( $day_schedule['currenty_closed'] ) ? 'CLOSED' : $day_schedule['public_display']; ?></h2>
      <p class="legal-text"><?= get_field('hour_legal', 'option')?></p>
    </div>
    <?php if($day_schedule['member_display']): ?>
    <div class="widget-schedule">
      <p class="surtitle"><?= ucfirst(date('l')) ?>'s <?= ucfirst(pjg_get_season()) ?> Member Hours</p>
      <h2 class="widget-title"> <?= ( $day_schedule['currenty_closed'] ) ? 'CLOSED' : $day_schedule['member_display'] ?></h2>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <div class="widget-visit">
      <p class="surtitle">Visit Us</p>
      <address>
      611 SW Kingston Avenue<br/>
      Portland, OR 97205<br/>
      <a href="<?= get_permalink(get_page_by_path('parking')); ?>">Get Directions</a>
      </address>
    </div>
  </div>
</li>
