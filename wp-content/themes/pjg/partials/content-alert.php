<div class="global-alert color-<?= $alert_color; ?>">
    <div class="global-alert-close">close</div>

    <div class="wrapper">
        <div class="global-alert-row">
            <div class="global-alert-title">
                <div class="title"><?= $alert_post->post_title; ?></div>
            </div>
            <div class="global-alert-copy">

                <?php if( !empty($alert_post->post_content) ) : ?>
                <div class="global-alert-content"><?= apply_filters( 'the_content', $alert_post->post_content ); ?>


                  <?php if( $alert_text != '' && $alert_url != '' ) :

                    $alertURL = '<a href="' . $alert_url  . '">' . $alert_text  . '</a>';
                    $alertURL_arrow = '<a class="arrow" href="' . $alert_url  . '"></a>';

                    $alertURL = autoblank( $alertURL );
                    $alertURL_arrow = autoblank( $alertURL_arrow );

                    ?>
                  <div class="global-alert-cta"><?php echo $alertURL; ?></div>
                  <?php echo $alertURL_arrow; ?>
                  <?php endif; ?>


                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
