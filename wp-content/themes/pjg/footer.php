<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package pjg
 */

?>

  <?php // Lower Page Modules

  if( !is_search() && !is_category() ) {

    get_template_part( 'partials/module', 'lower-page' );

  };

  ?>

  </div><!-- #content -->

  <footer id="fat-footer">
    <?php get_template_part('partials/module', 'visitor-info'); ?>
  </footer>
  <footer id="colophon" class="site-footer content-width" role="contentinfo">

    <div class="row row-top">

      <div class="extras">

        <?php if( have_rows( 'social_links', 'option' ) ) : ?>

        <div class="item follow">

          <div class="label">Follow Us</div>
          <div class="footer-content social">

            <?php while( have_rows( 'social_links', 'option' ) ) : the_row(); ?>

              <a target="_blank" class="icon <?php echo get_sub_field( 'social_type' );?>" href="<?php echo get_sub_field( 'social_url' );?>"><?php echo get_sub_field( 'social_type' );?></a>

            <?php endwhile ?>

          </div>


        </div>

        <?php endif; ?>

        <div class="item newsletter">

          <div class="label">Sign Up for Our Newsletter</div>
          <div class="footer-content">

            <!-- Begin MailChimp Signup Form -->
            <form action="//japanesegarden.us14.list-manage.com/subscribe/post?u=03786987ef3b2edd865041f15&amp;id=e5eb0877e9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate newsletter-form" target="_blank" novalidate>

              <div class="mc-field-group">
              	<label for="mce-EMAIL" class="newsletter-email">Email Address </label>
              	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Enter your email address...">

                <div id="mce-responses" class="clear">
                  <div class="response" id="mce-error-response" style="display:none"></div>
                  <div class="response" id="mce-success-response" style="display:none"></div>
                </div>
                
              </div>

              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_03786987ef3b2edd865041f15_e5eb0877e9" tabindex="-1" value=""></div>
              <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button newsletter-submit">

              <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>


            </form>

            <!--End mc_embed_signup-->

          </div>

        </div>

      </div>

      <div class="item footer-nav-wrapper">

        <div class="label">Additional Links</div>

        <?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>

      </div>

    </div>

    <div class="row row-bottom">


      <?php if( have_rows( 'sponsor_links', 'option' ) ) : ?>

      <div class="sponsors">

        <div class="label">Thank You to Our Sponsors</div>

          <div class="sponsors-wrapper">

            <?php while( have_rows( 'sponsor_links', 'option' ) ) : the_row();

              $image = get_sub_field( 'sponsor_logo' );

              if( get_sub_field( 'sponsor_url' ) != '' ) :

             ?>


              <a target="_blank" class="sponsor-logo" href="<?php echo get_sub_field( 'sponsor_url' );?>"><img src="<?php echo $image['sizes']['sponsor-logo']; ?>" /></a>

            <?php else : ?>

              <span class="sponsor-logo"><img src="<?php echo $image['sizes']['sponsor-logo']; ?>" /></span>

            <?php endif; endwhile ?>

          </div>

      </div>

      <?php endif; ?>

    </div>

  </footer><!-- #colophon -->
  <div class="overlay-nav-body"></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
