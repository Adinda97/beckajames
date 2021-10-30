<?php get_header(); ?>
<div id="content">
	<div class="row content">
		<div class="col-lg-10 mx-auto my-5 columns">
			<div class="columns">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							 
				<?php the_content(); ?>
				 
				<p class="text-center"><?php posts_nav_link(); ?></p>
				<?php endwhile; else: ?>
				 
				<h2>Woops...</h2>
				 
				<p>Deze pagina heeft geen content.</p>
				 
				<?php endif; ?>
				 
				
			</div>
		
		</div>
	</div>	
</div>	

			

<?php
get_footer();

?>