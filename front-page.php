<?php
/* Template Name: Homepagina */

get_header();
?>
<?php is_front_page(); ?>

<!-- Banner Section -->
<div id="banner">
	<div class="row full banner" style="background-image: url(https://beckajames.nl/wp-content/uploads/2021/04/felipe-galvan-AhfrA5VQNpM-unsplash-scaled.jpg)">
		<div class="medium-7 medium-offset-5 columns text-center">
			<img style="width:100%;" src="https://beckajames.nl/wp-content/uploads/2021/04/original-becka-james.png"/>
			<a href="#" class="button">Shop direct</a>
		</div>
	</div>
</div>

<div id="categorylist">
	<div class="row full">
		<div class="large-12 small-12 columns text-center">
			<h2>Shop per categorie</h2>
		</div>
		<?php
			$categorylist = get_field('categorylist', 'option');
			if($categorylist)
			{

				foreach($categorylist as $categoryitem)
				{ ?>
					<div class="columns large-2 medium-6 small-6" style="padding: 0 20px;">
						<div class="row align-middle categoryitem">
							<div class="columns large-4">
								<img src="<?php echo $categoryitem['category_icon'] ?>">
							</div>
							<div class="columns large-8 categoryitem-text">
								<p><?php echo $categoryitem['category_name'] ?> </p>
							</div>
						</div>
					</div>
				<?php }
			}
		?>
	</div>
</div>

<!-- Categories Section -->
<div id="categories">
	<div class="row full">

			<?php

			  $taxonomy     = 'product_cat';
			  $orderby      = 'name';  
			  $title        = '';  
			  $empty        = 0;

			  $args = array(
					 'taxonomy'     => $taxonomy,
					 'orderby'      => $orderby,
					 'title_li'     => $title,
					 'hide_empty'   => $empty
			  );


			 $all_categories = get_categories( $args );
			 foreach ($all_categories as $cat) { ?>
					<?php if($cat->category_parent == 0) {
						// $category_id = $cat->term_id; 
						$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
						$image = wp_get_attachment_url( $thumbnail_id ); ?>
						
						<div class="large-6 small-12 columns category" style="background-image: url('<?php echo $image ?>');">
							<h2 class="category-title"><a href="<?php echo get_term_link($cat->slug, 'product_cat') ?>"><?php echo $cat->name ?></a></h2>
							<p class="category-description"><?php echo $cat->description ?></p>
							<a href="<?php echo get_term_link($cat->slug, 'product_cat') ?>" class="button">Lees meer</a>
						</div>	
					<?php } ?>				
			<?php } ?>
	</div>	
</div>

<!-- Products Section -->
	<div id="products" class= "archive">
		<div class="row full" data-equalizer>
		<div class="large-12 small-12 columns text-center">
			<h2>Onze topproducten</h2>
		</div>
		<?php if (have_posts()) :     
		
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$secondArgs = null;
		
					$args = array(
						'post_type'      => 'product',
						'posts_per_page' => 6,
						'paged' => $paged
						
					);

					$secondArgs = array(
						'post_type'      => 'product',
						'posts_per_page' => 4,
						'paged' => $paged,
						'offset' => 6
					);
				

			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				$productID = $product->get_id();
				$productVar = wc_get_product( $productID );
				$checkout_url = wc_get_checkout_url(); 

		?>

		<div class="large-3 medium-6 small-12 columns product" data-equalizer-watch>
			<img style="width:100%;" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" class="product__image mx-auto" />
			<p class="product-title mt-4"><?php the_title() ?></p>
			<?php echo $product->get_price_html();  ?><br>
			<!-- <?php echo '<a href="'. $checkout_url.'?add-to-cart=' .$productID. '" class="button">'?>In winkelwagen</a> -->
			<a href="<?php echo $product->get_permalink(); ?>" class="button">In winkelwagen</a>
		</div>

		<?php endwhile; ?>

		<div class="large-6 medium-12 small-12 columns productblock text-center" style=" padding: 10%; background-image: url('http://localhost/BeckaJames/wp-content/uploads/2021/10/tyler-nix-fo83GD_AARE-unsplash.jpg');">
				<h2 class="productblock-title">Nieuw!</h2>
				<span class="productblock-subtitle">Bekijk onze nieuwste producten</span>
		</div>
			<?php
				$secondLoop = new WP_Query( $secondArgs );
				while ( $secondLoop->have_posts() ) : $secondLoop->the_post();
						global $product;
						$productID = $product->get_id();
						$productVar = wc_get_product( $productID );
						$checkout_url = wc_get_checkout_url(); 

				?>

				<div class="large-3 medium-6 small-12 columns product" data-equalizer-watch>
					<img style="width:100%;" src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" class="product__image mx-auto" />
					<p class="product-title mt-4"><?php the_title() ?></p>
					<?php echo $product->get_price_html(); ?><br>
					<a href="<?php echo $product->get_permalink(); ?>" class="button">In winkelwagen</a>
				</div>
			<?php endwhile; ?>
			 <?php else: ?>
			<p>Sorry, er zijn geen producten gevonden<p>
			<?php endif ?>
		</div>
	</div>	
</div>

<div id="standout">
	<div class="standout" style="background-image: url('http://localhost/BeckaJames/wp-content/uploads/2021/10/katsiaryna-endruszkiewicz-I27xgU5RSFM-unsplash.jpg');">
		<div class="row">
			<div class="large-12 small-12">
			<h2>Becka James, dé online shop voor sieraden & accessoires</h2>
				<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek. Wat u hier leest is een voorbeeldtekst. Deze wordt later vervangen door de uiteindelijke tekst, die nu nog niet bekend is. De faketekst is dus een tekst die eigenlijk nergens over gaat. Het grappige is, dat mensen deze toch vaak lezen. Zelfs als men weet dat het om een faketekst gaat, lezen ze toch door.<p>
			</div>
		</div>
	</div>
</div>

<div id="instagram">
	<div class="row full" data-equalizer>
		<div class="large-6 medium-12 small-12 columns instagram" data-equalizer-watch>
			<?php echo do_shortcode('[instagram-feed]'); ?>
		</div>
		<div class="large-6 medium-12 small-12 columns information" data-equalizer-watch>
			<div style="background-size: cover; padding: 10%; min-height: 460px; background-image: url('http://localhost/BeckaJames/wp-content/uploads/2021/10/inkredo-designer-dbuZjDwDn0o-unsplash.jpg');">
				<h2>Volg ons op social media</h2>
				<p>Blijf op de hoogte via onze social media kanalen</p>
				<div class="row">
				<?php
					$socialmedialist = get_field('socialmedialist', 'option');
					if($socialmedialist)
					{

						foreach($socialmedialist as $socialmediaitem)
						{ ?>
							<div class="columns large-2 medium-6 small-6 socialmediaitem">
								<a href="<?php echo $socialmediaitem['social_link'] ?>"><img src="<?php echo $socialmediaitem['social_icon'] ?>"></a>
							</div>
						<?php }
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="about">
	<div class="row">
		<div class="large-12 medium-12 small-12 columns">
			<h2>Hier kan tekst komen te staan</h2>
		</div>
		<div class="large-6 medium-6 small-12  columns">
			<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek. Wat u hier leest is een voorbeeldtekst. Deze wordt later vervangen door de uiteindelijke tekst, die nu nog niet bekend is. De faketekst is dus een tekst die eigenlijk nergens over gaat. Het grappige is, dat mensen deze toch vaak lezen. Zelfs als men weet dat het om een faketekst gaat, lezen ze toch door.</p>
		</div>
		<div class="large-6 medium-6 small-12  columns">
			<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek. Wat u hier leest is een voorbeeldtekst. Deze wordt later vervangen door de uiteindelijke tekst, die nu nog niet bekend is. De faketekst is dus een tekst die eigenlijk nergens over gaat. Het grappige is, dat mensen deze toch vaak lezen. Zelfs als men weet dat het om een faketekst gaat, lezen ze toch door.</p>
		</div>
	</div>
</div>


<?php
get_footer();

?>