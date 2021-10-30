<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Adinda Media
 * @since 1.0.0
 */

?>
<footer>
	<div id="footer" style="position: relative;">
		<div class="row">
				<div class="large-3 medium-6 small-12 columns">
					<span>Hoe kunnen wij jou helpen?</span>
					<p class="col-10"><?php the_field('description', 'option'); ?></p>
					<div class="socials__container col-6 mt-4 d-flex flex-row justify-content-start">
						<?php
							$socials_rows = get_field('social_media', 'option');
								if($usp_rows)
								{
									foreach($socials_rows as $row)
									{
										$image = $row['icon'];
										echo '<a class="me-3" href="'. $row['link'] .'"><img src="'. $image .'" style="width: 50px; height: 50px; object-fit: cover;"></a>';
									}
								}
						?>
					</div>
					

				</div>
				<div class="large-3  medium-6 small-12 columns">
					<span>Klantenservice</span>
					<?php wp_nav_menu( array( 'theme_location' => 'footer_customerservice' ) ); ?>
				</div>
				<div class="large-3  medium-6 small-12columns">
				<span>Informatie</span>
					<?php wp_nav_menu( array( 'theme_location' => 'footer_information' ) ); ?>
				</div>
				<div class="large-3 medium-6 small-12 columns">
				<span>Waar vind je ons?</span>
					<?php the_field('address_details', 'option'); ?>
					<a href="tel:<?php the_field('phonenumber', 'option'); ?>"><?php the_field('phonenumber', 'option'); ?></a><br>
					<a href="mailto:<?php the_field('emailaddress', 'option'); ?>"><?php the_field('emailaddress', 'option'); ?></a>
				</div>
		</div>
	</div>	
<div id="copyright">
	<div class="row full txt-center"> 
		<p>© Copryright Becka James - Algemene voorwaarden | Privacyverklaring | Disclaimer </p>
	</div>
</div>


</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
       <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.3/dist/js/foundation.min.js" crossorigin="anonymous"></script>
	   <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/custom.js"></script>
</body>

<?php wp_footer(); ?>

